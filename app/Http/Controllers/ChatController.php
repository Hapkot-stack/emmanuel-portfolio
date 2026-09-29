<?php
namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\ChatMessage;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate(['message' => 'required|string|max:1000']);

        $sessionId = $request->session()->getId();
        $userMsg   = trim($request->input('message'));

        // Store user message
        ChatMessage::create(['session_id' => $sessionId, 'role' => 'user',
            'content' => $userMsg, 'ip_address' => $request->ip()]);

        // Build context from database
        $context = $this->buildContext();

        // History (last 6 messages)
        $history = ChatMessage::where('session_id', $sessionId)
            ->orderByDesc('created_at')->take(6)->get()->reverse()
            ->map(fn($m) => ['role' => $m->role, 'content' => $m->content])
            ->values()->toArray();

        $messages = array_merge([
            ['role' => 'system', 'content' => $context],
        ], $history);

        // Try OpenAI, fall back to rule-based
        $reply = $this->askOpenAI($messages) ?? $this->ruleBasedReply($userMsg);

        // Store assistant reply
        ChatMessage::create(['session_id' => $sessionId, 'role' => 'assistant',
            'content' => $reply, 'ip_address' => $request->ip()]);

        return response()->json(['reply' => $reply]);
    }

    private function buildContext(): string
    {
        $profile  = Profile::first();
        $skills   = Skill::orderBy('sort_order')->pluck('name')->implode(', ');
        $projects = Project::visible()->get()->map(fn($p) =>
            "- {$p->title} ({$p->status}): {$p->short_description}" .
            ($p->github_url ? " [GitHub: {$p->github_url}]" : '') .
            ($p->website_available && $p->website_url ? " [Live: {$p->website_url}]" : '')
        )->implode("\n");
        $experience  = Experience::orderBy('sort_order')->get()->map(fn($e) => "- {$e->title} at {$e->company} ({$e->period})")->implode("\n");
        $education   = Education::orderBy('sort_order')->get()->map(fn($e) => "- {$e->degree} at {$e->institution} ({$e->period})")->implode("\n");
        $certs       = Certificate::orderBy('sort_order')->get()->map(fn($c) => "- {$c->title} by {$c->issuer} ({$c->year})")->implode("\n");

        return <<<PROMPT
You are an AI portfolio assistant for {$profile->name}. Answer visitor questions about Emmanuel's professional background clearly and concisely.

PROFILE:
Name: {$profile->name}
Title: {$profile->title}
Location: {$profile->location}
Email: {$profile->email}
Phone: {$profile->phone}
GitHub: {$profile->github_url}
LinkedIn: {$profile->linkedin_url}
Bio: {$profile->bio}

SKILLS: {$skills}

PROJECTS:
{$projects}

EXPERIENCE:
{$experience}

EDUCATION:
{$education}

CERTIFICATIONS:
{$certs}

CV DOWNLOADS: Visitors can download CVs at /cv
RESUME: Visitors can view the full resume at /resume
CONTACT: Visitors can contact Emmanuel at /contact or email {$profile->email}

Rules:
- Be helpful, friendly, and professional.
- If asked about something not in the context, say you don't have that info but suggest contacting Emmanuel.
- Keep answers concise (2-4 sentences max unless more detail is needed).
- For CV/resume requests, provide the direct URL.
PROMPT;
    }

    private function askOpenAI(array $messages): ?string
    {
        $apiKey = config('openai.api_key');
        if (!$apiKey || $apiKey === 'your-openai-key') return null;

        try {
            $response = Http::withToken($apiKey)
                ->timeout(15)
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model'       => 'gpt-3.5-turbo',
                    'messages'    => $messages,
                    'max_tokens'  => 400,
                    'temperature' => 0.7,
                ]);

            if ($response->successful()) {
                return $response->json('choices.0.message.content');
            }
        } catch (\Throwable) {}

        return null;
    }

    private function ruleBasedReply(string $msg): string
    {
        $msg  = strtolower($msg);
        $profile = Profile::first();

        if (str_contains($msg, 'who') && str_contains($msg, 'emmanuel')) {
            return "Emmanuel Tokpah is a {$profile->title} based in {$profile->location}. {$profile->bio_short}";
        }
        if (str_contains($msg, 'project')) {
            $projects = Project::visible()->take(3)->get()->map(fn($p) => $p->title)->implode(', ');
            return "Emmanuel has built several projects including: {$projects}. View all at /projects.";
        }
        if (str_contains($msg, 'skill') || str_contains($msg, 'laravel') || str_contains($msg, 'php')) {
            $skills = Skill::where('featured', true)->pluck('name')->implode(', ');
            return "Emmanuel's key skills include: {$skills}. View the full skills list on the portfolio.";
        }
        if (str_contains($msg, 'certif')) {
            $certs = Certificate::pluck('title')->implode(', ');
            return "Emmanuel holds the following certificates: {$certs}.";
        }
        if (str_contains($msg, 'cv') || str_contains($msg, 'resume') || str_contains($msg, 'download')) {
            return "You can download Emmanuel's CV at <a href='/cv' class='text-blue-400 underline'>/cv</a>. There are 4 versions: Developer, NGO, Data Officer, and ICT Officer.";
        }
        if (str_contains($msg, 'contact') || str_contains($msg, 'hire') || str_contains($msg, 'email')) {
            return "You can contact Emmanuel at {$profile->email} or via WhatsApp at {$profile->phone}. Or use the <a href='/#contact' class='text-blue-400 underline'>contact form</a>.";
        }
        if (str_contains($msg, 'github')) {
            return "Emmanuel's GitHub: <a href='{$profile->github_url}' target='_blank' class='text-blue-400 underline'>{$profile->github_url}</a>";
        }
        if (str_contains($msg, 'linkedin')) {
            return "Emmanuel's LinkedIn: <a href='{$profile->linkedin_url}' target='_blank' class='text-blue-400 underline'>{$profile->linkedin_url}</a>";
        }
        if (str_contains($msg, 'experience') || str_contains($msg, 'work')) {
            $exp = Experience::first();
            return $exp ? "Emmanuel's most recent role was {$exp->title} at {$exp->company} ({$exp->period}). View full experience on the resume page." : "View Emmanuel's full experience at /resume.";
        }
        if (str_contains($msg, 'education') || str_contains($msg, 'university') || str_contains($msg, 'degree')) {
            $edu = Education::first();
            return $edu ? "Emmanuel is currently studying {$edu->degree} at {$edu->institution} ({$edu->period})." : "View Emmanuel's education at /resume.";
        }
        return "Hi! I'm Emmanuel's portfolio assistant. I can answer questions about his skills, projects, experience, certifications, or how to contact him. What would you like to know?";
    }
}

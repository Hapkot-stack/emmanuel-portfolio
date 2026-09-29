<style>
    :root {
        --admin-sidebar: #1E293B;
        --admin-content: #F8FAFC;
        --admin-card: #FFFFFF;
        --admin-primary: #2563EB;
        --admin-accent: #2563EB;
        --admin-special: #8B5CF6;
    }

    .fi-sidebar,
    .fi-sidebar-header {
        background: var(--admin-sidebar);
    }

    .fi-sidebar {
        border-right: 1px solid rgba(148, 163, 184, 0.16);
    }

    .fi-sidebar-group-label {
        color: #FFFFFF !important;
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
    }

    .fi-sidebar-item-button {
        border-radius: 0.625rem;
        color: #FFFFFF !important;
        transition: background-color 160ms ease, color 160ms ease;
    }

    .fi-sidebar-item-label {
        color: #FFFFFF !important;
    }

    .fi-sidebar-item-button:hover {
        background: rgba(37, 99, 235, 0.15);
        color: #FFFFFF;
    }

    .fi-sidebar-item.fi-active>.fi-sidebar-item-button {
        background: linear-gradient(135deg, #2563EB, #3B82F6);
        box-shadow: inset 3px 0 0 #2563EB;
        color: #FFFFFF;
    }

    .fi-sidebar-item.fi-active .fi-sidebar-item-icon {
        color: #FFFFFF !important;
    }

    .fi-sidebar-item-icon {
        color: #60A5FA !important;
    }

    .cms-section-card {
        border-radius: 0.75rem;
        box-shadow: 0 1px 2px rgba(15, 23, 42, 0.05), 0 8px 20px rgba(15, 23, 42, 0.06);
        transition: border-color 160ms ease, box-shadow 160ms ease, transform 160ms ease;
    }

    .cms-section-card:hover {
        border-color: rgba(37, 99, 235, 0.45);
        box-shadow: 0 8px 24px rgba(37, 99, 235, 0.1);
        transform: translateY(-2px);
    }

    .cms-back-link {
        align-items: center;
        color: #1D4ED8;
        display: inline-flex;
        font-size: 0.875rem;
        font-weight: 600;
        gap: 0.5rem;
        text-decoration: none;
    }

    .cms-back-link:hover {
        color: #1E40AF;
        text-decoration: underline;
        text-underline-offset: 3px;
    }

    .fi-main-ctn,
    .fi-main,
    .fi-topbar {
        background: var(--admin-content);
    }

    .fi-topbar {
        border-bottom: 1px solid #E2E8F0;
    }

    .fi-section,
    .fi-wi-stats-overview-stat {
        background: var(--admin-card);
        border-color: #E2E8F0;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.05), 0 8px 24px rgba(15, 23, 42, 0.04);
    }

    .fi-btn-color-primary {
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.18);
    }

    .fi-badge-color-primary,
    .fi-icon-color-primary {
        color: var(--admin-special);
    }
</style>
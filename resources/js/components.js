// Modal Component
class Modal {
    constructor() {
        this.init();
    }

    init() {
        // Listen for custom events to open/close modals
        document.addEventListener('open-modal', (e) => {
            this.open(e.detail);
        });

        document.addEventListener('close-modal', (e) => {
            this.close(e.detail);
        });

        // Close modal on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.closeAll();
            }
        });

        // Close modal when clicking outside
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('modal-overlay')) {
                this.closeAll();
            }
        });
    }

    open(name) {
        const modal = document.querySelector(`[data-modal-name="${name}"]`);
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('block');
            document.body.classList.add('overflow-y-hidden');
            
            // Focus first focusable element
            const focusables = this.getFocusableElements(modal);
            if (focusables.length > 0) {
                setTimeout(() => focusables[0].focus(), 100);
            }

            // Handle tab trapping
            this.setupTabTrapping(modal);
        }
    }

    close(name) {
        const modal = document.querySelector(`[data-modal-name="${name}"]`);
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('block');
            document.body.classList.remove('overflow-y-hidden');
        }
    }

    closeAll() {
        const modals = document.querySelectorAll('[data-modal-name]');
        modals.forEach(modal => {
            modal.classList.add('hidden');
            modal.classList.remove('block');
        });
        document.body.classList.remove('overflow-y-hidden');
    }

    getFocusableElements(modal) {
        const selector = 'a, button, input:not([type=\'hidden\']), textarea, select, details, [tabindex]:not([tabindex=\'-1\'])';
        return [...modal.querySelectorAll(selector)].filter(el => !el.hasAttribute('disabled'));
    }

    setupTabTrapping(modal) {
        const focusables = this.getFocusableElements(modal);
        if (focusables.length === 0) return;

        const firstFocusable = focusables[0];
        const lastFocusable = focusables[focusables.length - 1];

        const trapFocus = (e) => {
            if (e.key === 'Tab') {
                if (e.shiftKey) {
                    if (document.activeElement === firstFocusable) {
                        e.preventDefault();
                        lastFocusable.focus();
                    }
                } else {
                    if (document.activeElement === lastFocusable) {
                        e.preventDefault();
                        firstFocusable.focus();
                    }
                }
            }
        };

        modal.addEventListener('keydown', trapFocus);

        // Clean up when modal is closed
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.target.classList.contains('hidden')) {
                    modal.removeEventListener('keydown', trapFocus);
                    observer.disconnect();
                }
            });
        });

        observer.observe(modal, { attributes: true, attributeFilter: ['class'] });
    }
}

// Dropdown Component
class Dropdown {
    constructor() {
        this.init();
    }

    init() {
        // Handle dropdown clicks
        document.addEventListener('click', (e) => {
            const trigger = e.target.closest('[data-dropdown-trigger]');
            if (trigger) {
                e.preventDefault();
                this.toggle(trigger);
            }

            // Close dropdown when clicking outside
            if (!e.target.closest('[data-dropdown]')) {
                this.closeAll();
            }
        });

        // Close dropdown on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.closeAll();
            }
        });
    }

    toggle(trigger) {
        const dropdown = trigger.closest('[data-dropdown]');
        const content = dropdown.querySelector('[data-dropdown-content]');
        
        if (content.classList.contains('hidden')) {
            this.closeAll();
            this.open(dropdown);
        } else {
            this.close(dropdown);
        }
    }

    open(dropdown) {
        const content = dropdown.querySelector('[data-dropdown-content]');
        content.classList.remove('hidden');
        content.classList.add('block');
    }

    close(dropdown) {
        const content = dropdown.querySelector('[data-dropdown-content]');
        content.classList.add('hidden');
        content.classList.remove('block');
    }

    closeAll() {
        const dropdowns = document.querySelectorAll('[data-dropdown]');
        dropdowns.forEach(dropdown => this.close(dropdown));
    }
}

// Success Message Component
class SuccessMessage {
    constructor() {
        this.init();
    }

    init() {
        // Auto-hide success messages after 2 seconds
        const messages = document.querySelectorAll('[data-success-message]');
        messages.forEach(message => {
            setTimeout(() => {
                message.style.transition = 'opacity 0.3s ease-out';
                message.style.opacity = '0';
                setTimeout(() => {
                    message.style.display = 'none';
                }, 300);
            }, 2000);
        });
    }
}

// Mobile Menu Component
class MobileMenu {
    constructor() {
        this.init();
    }

    init() {
        // Handle mobile menu toggle
        document.addEventListener('click', (e) => {
            const trigger = e.target.closest('[data-mobile-menu-trigger]');
            if (trigger) {
                e.preventDefault();
                this.toggle();
            }
        });
    }

    toggle() {
        const menu = document.querySelector('[data-mobile-menu]');
        const icon = document.querySelector('[data-mobile-menu-icon]');
        const close = document.querySelector('[data-mobile-menu-close]');
        
        if (icon.classList.contains('inline-flex')) {
            // Close menu
            icon.classList.add('hidden');
            icon.classList.remove('inline-flex');
            close.classList.remove('hidden');
            close.classList.add('inline-flex');
        } else {
            // Open menu
            icon.classList.remove('hidden');
            icon.classList.add('inline-flex');
            close.classList.add('hidden');
            close.classList.remove('inline-flex');
        }
    }
}

// Initialize components when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    new Modal();
    new Dropdown();
    new SuccessMessage();
    new MobileMenu();
    
    // Handle modal triggers
    document.addEventListener('click', (e) => {
        const trigger = e.target.closest('[data-open-modal]');
        if (trigger) {
            e.preventDefault();
            const modalName = trigger.dataset.openModal;
            const event = new CustomEvent('open-modal', { detail: modalName });
            document.dispatchEvent(event);
        }
        
        const closeTrigger = e.target.closest('[data-close-modal]');
        if (closeTrigger) {
            e.preventDefault();
            const event = new CustomEvent('close-modal', { detail: 'confirm-user-deletion' });
            document.dispatchEvent(event);
        }
    });
});

// Export for potential external use
window.Modal = Modal;
window.Dropdown = Dropdown;

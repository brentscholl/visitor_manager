// import './bootstrap';

// Import Tippy for tooltips
import tippy from 'tippy.js';
import 'tippy.js/dist/tippy.css';

// Import Alpine.js components
import listboxComponent from './components/listbox';
import menuComponent from './components/menu';
import radioGroupComponent from './components/radioGroup';

// Initialize tooltips on elements with a [tooltip] attribute
function initializeTooltips() {
    document.querySelectorAll('[tooltip]').forEach(tool => {
        const placement = tool.getAttribute('tooltip-p') || 'top';
        tippy(tool, {
            content: tool.getAttribute('tooltip'),
            placement: placement,
            animation: 'shift-away-subtle',
            delay: [500, 0], // Delay on hover
        });
    });
}

// Smooth scrolling for anchor links
function smoothScrollAnchors() {
    document.querySelectorAll('a[href^="#"]').forEach(link => {
        link.addEventListener('click', event => {
            event.preventDefault();
            const targetId = link.getAttribute('href');
            const targetElement = document.querySelector(targetId);

            if (targetElement) {
                const targetScrollPosition = targetElement.offsetTop;
                window.scrollTo({
                    top: targetScrollPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
}

// Reinitialize components after Livewire updates
function reinitializeComponents() {
    initializeTooltips();
    smoothScrollAnchors();
}

// Livewire Hooks
Livewire.hook('component.initialized', component => {
    reinitializeComponents();
});

document.addEventListener("livewire:update", reinitializeComponents);

// Listen for custom events to scroll to elements by ID
window.addEventListener('scroll-to-element', event => {
    const element = document.getElementById(event.detail.id);
    if (element) {
        const targetScrollPosition = element.offsetTop;
        window.scrollTo({
            top: targetScrollPosition,
            behavior: 'smooth'
        });
    }
});

// Initialize components on page load
initializeTooltips();
smoothScrollAnchors();

// Components registration for Alpine.js
window.Components = {
    listbox: listboxComponent,
    menu: menuComponent,
    radioGroup: radioGroupComponent,
    // Add other components as needed
};

// Initialize Alpine.js components globally
Object.keys(window.Components).forEach(componentName => {
    Alpine.data(componentName, window.Components[componentName]);
});

// Custom Alpine.js menu component configuration
Alpine.data('menu', () => ({
    open: false,
    disableClickAway: false,
    activeDescendant: null,
    activeIndex: null,
    items: null,
    init() {
        this.items = Array.from(this.$el.querySelectorAll('[role="menuitem"]'));
        this.$watch("open", () => {
            if (this.open) this.activeIndex = -1;
        });
    },
    focusButton() {
        this.$refs.button.focus();
    },
    onButtonClick() {
        this.open = !this.open;
        if (this.open) {
            this.$nextTick(() => {
                this.$refs["menu-items"].focus();
            });
        }
    },
    onButtonEnter() {
        this.open = !this.open;
        if (this.open) {
            this.activeIndex = 0;
            this.activeDescendant = this.items[this.activeIndex].id;
            this.$nextTick(() => {
                this.$refs["menu-items"].focus();
            });
        }
    },
    onArrowUp() {
        if (!this.open) {
            this.open = true;
            this.activeIndex = this.items.length - 1;
            this.activeDescendant = this.items[this.activeIndex].id;
            return;
        }
        if (this.activeIndex !== 0) {
            this.activeIndex = this.activeIndex === -1 ? this.items.length - 1 : this.activeIndex - 1;
            this.activeDescendant = this.items[this.activeIndex].id;
        }
    },
    onArrowDown() {
        if (!this.open) {
            this.open = true;
            this.activeIndex = 0;
            this.activeDescendant = this.items[this.activeIndex].id;
            return;
        }
        if (this.activeIndex !== this.items.length - 1) {
            this.activeIndex += 1;
            this.activeDescendant = this.items[this.activeIndex].id;
        }
    },
    onClickAway(e) {
        if (!this.disableClickAway && this.open) {
            const focusableElements = ["[contentEditable=true]", "[tabindex]", "a[href]", "area[href]", "button:not([disabled])", "iframe", "input:not([disabled])", "select:not([disabled])", "textarea:not([disabled])"].map(e => `${e}:not([tabindex='-1'])`).join(",");
            this.open = false;
            if (!e.target.closest(focusableElements)) this.focusButton();
        }
    }
}));

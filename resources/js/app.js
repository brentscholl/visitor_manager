// import './bootstrap';

// Import Tippy
import tippy from 'tippy.js';
import 'tippy.js/dist/tippy.css';

// Import Alpine Components
import listboxComponent from './components/listbox';
import menuComponent from './components/menu';
import radioGroupComponent from './components/radioGroup';

// Initialize tooltips
function initializeTooltips() {
    document.querySelectorAll('[tooltip]').forEach(tool => {
        const placement = tool.getAttribute('tooltip-p') || 'top';
        tippy(tool, {
            content: tool.getAttribute('tooltip'),
            placement: placement,
            animation: 'shift-away-subtle',
            delay: [500, 0], // ms
        });
    });
}

// Smooth scroll for anchor links
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

// Function to reinitialize components after Livewire updates
function reinitializeComponents() {
    initializeTooltips();
    smoothScrollAnchors();
}

// Livewire Hooks
Livewire.hook('component.initialized', component => {
    reinitializeComponents();
});

document.addEventListener("livewire:update", reinitializeComponents);

// Custom event listener for scrolling to elements
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

// Components -------------------------------------------------------------------------
window.Components = {
    listbox: listboxComponent,
    menu: menuComponent,
    radioGroup: radioGroupComponent,
    // Register other components similarly
};

// Initialize Alpine.js components
Object.keys(window.Components).forEach(componentName => {
    Alpine.data(componentName, window.Components[componentName]);
});

Alpine.data('menu', () => ({
    open: false,
    disableClickAway: false,
    activeDescendant: null,
    activeIndex: null,
    items: null,
    init() {
        this.items = Array.from(this.$el.querySelectorAll('[role="menuitem"]')), this.$watch("open", (() => {
            console.log('init.2');
            this.open && (this.activeIndex = -1);
        }));
    },
    focusButton() {
        this.$refs.button.focus();
    },
    onButtonClick() {
        this.open = !this.open, this.open && this.$nextTick((() => {
            this.$refs["menu-items"].focus();
        }));
    },
    onButtonEnter() {
        this.open = !this.open, this.open && (this.activeIndex = 0, this.activeDescendant = this.items[this.activeIndex].id, this.$nextTick((() => {
            this.$refs["menu-items"].focus();
        })));
    },
    onArrowUp() {
        if (!this.open) return this.open = !0, this.activeIndex = this.items.length - 1, void (this.activeDescendant = this.items[this.activeIndex].id);
        0 !== this.activeIndex && (this.activeIndex = -1 === this.activeIndex ? this.items.length - 1 : this.activeIndex - 1, this.activeDescendant = this.items[this.activeIndex].id);
    },
    onArrowDown() {
        if (!this.open) return this.open = !0, this.activeIndex = 0, void (this.activeDescendant = this.items[this.activeIndex].id);
        this.activeIndex !== this.items.length - 1 && (this.activeIndex = this.activeIndex + 1, this.activeDescendant = this.items[this.activeIndex].id);
    },
    onClickAway(e) {
        if(!this.disableClickAway) {
            if (this.open) {
                const t = ["[contentEditable=true]", "[tabindex]", "a[href]", "area[href]", "button:not([disabled])", "iframe", "input:not([disabled])", "select:not([disabled])", "textarea:not([disabled])"].map((e => `${e}:not([tabindex='-1'])`)).join(",");
                this.open = !1, e.target.closest(t) || this.focusButton();
            }
        }
    }
}))

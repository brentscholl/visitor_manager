// tab.js
export default function tab(e = 0) {
    return {
        selected: !1, init() {
            let t = Array.from(this.$el.closest('[x-data^="Components.tabs("]').querySelectorAll('[x-data^="Components.tab("]'));
            this.selected = t.indexOf(this.$el) === e, this.$watch("selected", (e => {
                e && this.$el.focus();
            }));
        }, onClick() {
            window.dispatchEvent(new CustomEvent("tab-click", {detail: this.$el}));
        }, onKeydown(e) {
            ["ArrowLeft", "ArrowRight", "Home", "PageUp", "End", "PageDown"].includes(e.key) && e.preventDefault(), window.dispatchEvent(new CustomEvent("tab-keydown", {
                detail: {
                    tab: this.$el,
                    key: e.key
                }
            }));
        }, onTabSelect(e) {
            this.selected = e.detail.tab === this.$el;
        }
    };
}

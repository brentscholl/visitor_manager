// menu.js
export default function menu(e) {
    return {
        init() {
            this.items = Array.from(this.$el.querySelectorAll('[role="menuitem"]')), this.$watch("open", (() => {
                this.open && (this.activeIndex = -1);
            }));
        }, activeDescendant: null, activeIndex: null, items: null, open: e.open, focusButton() {
            this.$refs.button.focus();
        }, onButtonClick() {
            this.open = !this.open, this.open && this.$nextTick((() => {
                this.$refs["menu-items"].focus();
            }));
        }, onButtonEnter() {
            this.open = !this.open, this.open && (this.activeIndex = 0, this.activeDescendant = this.items[this.activeIndex].id, this.$nextTick((() => {
                this.$refs["menu-items"].focus();
            })));
        }, onArrowUp() {
            if (!this.open) return this.open = !0, this.activeIndex = this.items.length - 1, void (this.activeDescendant = this.items[this.activeIndex].id);
            0 !== this.activeIndex && (this.activeIndex = -1 === this.activeIndex ? this.items.length - 1 : this.activeIndex - 1, this.activeDescendant = this.items[this.activeIndex].id);
        }, onArrowDown() {
            if (!this.open) return this.open = !0, this.activeIndex = 0, void (this.activeDescendant = this.items[this.activeIndex].id);
            this.activeIndex !== this.items.length - 1 && (this.activeIndex = this.activeIndex + 1, this.activeDescendant = this.items[this.activeIndex].id);
        }, onClickAway(e) {
            if (this.open) {
                const t = ["[contentEditable=true]", "[tabindex]", "a[href]", "area[href]", "button:not([disabled])", "iframe", "input:not([disabled])", "select:not([disabled])", "textarea:not([disabled])"].map((e => `${e}:not([tabindex='-1'])`)).join(",");
                this.open = !1, e.target.closest(t) || this.focusButton();
            }
        }
    };
}
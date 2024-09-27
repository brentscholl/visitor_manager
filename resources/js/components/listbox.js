// listbox.js
export default function listbox(e) {
    return {
        init() {
            this.optionCount = this.$refs.listbox.children.length, this.$watch("activeIndex", (e => {
                this.open && (null !== this.activeIndex ? this.activeDescendant = this.$refs.listbox.children[this.activeIndex].id : this.activeDescendant = "");
            }));
        }, activeDescendant: null, optionCount: null, open: !1, activeIndex: null, selectedIndex: 0, get active() {
            return this.items[this.activeIndex];
        }, get [e.modelName || "selected"]() {
            return this.items[this.selectedIndex];
        }, choose(e) {
            this.selectedIndex = e, this.open = !1;
        }, onButtonClick() {
            this.open || (this.activeIndex = this.selectedIndex, this.open = !0, this.$nextTick((() => {
                this.$refs.listbox.focus(), this.$refs.listbox.children[this.activeIndex].scrollIntoView({block: "nearest"});
            })));
        }, onOptionSelect() {
            null !== this.activeIndex && (this.selectedIndex = this.activeIndex), this.open = !1, this.$refs.button.focus();
        }, onEscape() {
            this.open = !1, this.$refs.button.focus();
        }, onArrowUp() {
            this.activeIndex = this.activeIndex - 1 < 0 ? this.optionCount - 1 : this.activeIndex - 1, this.$refs.listbox.children[this.activeIndex].scrollIntoView({block: "nearest"});
        }, onArrowDown() {
            this.activeIndex = this.activeIndex + 1 > this.optionCount - 1 ? 0 : this.activeIndex + 1, this.$refs.listbox.children[this.activeIndex].scrollIntoView({block: "nearest"});
        }, ...e
    };
}
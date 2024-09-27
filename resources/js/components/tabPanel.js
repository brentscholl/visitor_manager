// tabPanel.js
export default function tabPanel(e) {
    return {
        selected: !1, init() {
            let t = Array.from(this.$el.closest('[x-data^="Components.tabs("]').querySelectorAll('[x-data^="Components.tabPanel("]'));
            this.selected = t.indexOf(this.$el) === e;
        }, onTabSelect(e) {
            this.selected = e.detail.panel === this.$el;
        }
    };
}

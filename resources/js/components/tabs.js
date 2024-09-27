// tabs.js
export default function tabs(e) {
    return {
        selectedIndex: 0, onTabClick(e) {
            if (!this.$el.contains(e.detail)) return;
            let t = Array.from(this.$el.querySelectorAll('[x-data^="Components.tab("]')), i = Array.from(this.$el.querySelectorAll('[x-data^="Components.tabPanel("]')),
                n = t.indexOf(e.detail);
            this.selectedIndex = n, window.dispatchEvent(new CustomEvent("tab-select", {detail: {tab: e.detail, panel: i[n]}}));
        }, onTabKeydown(e) {
            if (!this.$el.contains(e.detail.tab)) return;
            let t = Array.from(this.$el.querySelectorAll('[x-data^="Components.tab("]')), i = t.indexOf(e.detail.tab);
            "ArrowLeft" === e.detail.key ? this.onTabClick({detail: t[(i - 1 + t.length) % t.length]}) : "ArrowRight" === e.detail.key ? this.onTabClick({detail: t[(i + 1) % t.length]}) : "Home" === e.detail.key || "PageUp" === e.detail.key ? this.onTabClick({detail: t[0]}) : "End" !== e.detail.key && "PageDown" !== e.detail.key || this.onTabClick({detail: t[t.length - 1]});
        }
    };
}

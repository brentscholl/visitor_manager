// popoverGroup.js
export default function popoverGroup(e) {
    return {
        __type: "popoverGroup", init() {
            let e = t => {
                document.body.contains(this.$el) ? t.target instanceof Element && !this.$el.contains(t.target) && window.dispatchEvent(new CustomEvent("close-popover-group", {detail: this.$el})) : window.removeEventListener("focus", e, !0);
            };
            window.addEventListener("focus", e, !0);
        }
    };
}

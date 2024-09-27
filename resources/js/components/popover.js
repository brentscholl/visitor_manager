// popover.js
export default function popover({open: e = !1, focus: t = !1} = {}) {
    const i = ["[contentEditable=true]", "[tabindex]", "a[href]", "area[href]", "button:not([disabled])", "iframe", "input:not([disabled])", "select:not([disabled])", "textarea:not([disabled])"].map((e => `${e}:not([tabindex='-1'])`)).join(",");
    return {
        __type: "popover", open: e, init() {
            t && this.$watch("open", (e => {
                e && this.$nextTick((() => {
                    !function (e) {
                        const t = Array.from(e.querySelectorAll(i));
                        !function e(i) {
                            void 0 !== i && (i.focus({preventScroll: !0}), document.activeElement !== i && e(t[t.indexOf(i) + 1]));
                        }(t[0]);
                    }(this.$refs.panel);
                }));
            }));
            let e = i => {
                if (!document.body.contains(this.$el)) return void window.removeEventListener("focus", e, !0);
                let n = t ? this.$refs.panel : this.$el;
                if (this.open && i.target instanceof Element && !n.contains(i.target)) {
                    let e = this.$el;
                    for (; e.parentNode;) if (e = e.parentNode, e.__x instanceof this.constructor) {
                        if ("popoverGroup" === e.__x.$data.__type) return;
                        if ("popover" === e.__x.$data.__type) break;
                    }
                    this.open = !1;
                }
            };
            window.addEventListener("focus", e, !0);
        }, onEscape() {
            this.open = !1, this.restoreEl && this.restoreEl.focus();
        }, onClosePopoverGroup(e) {
            e.detail.contains(this.$el) && (this.open = !1);
        }, toggle(e) {
            this.open = !this.open, this.open ? this.restoreEl = e.currentTarget : this.restoreEl && this.restoreEl.focus();
        }
    };
}

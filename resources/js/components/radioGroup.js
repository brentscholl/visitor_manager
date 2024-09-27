// radioGroup.js
export default function radioGroup({initialCheckedIndex: e = 0} = {}) {
    return {
        value: void 0, active: void 0, init() {
            let t = Array.from(this.$el.querySelectorAll("input"));
            this.value = t[e]?.value;
            for (let e of t) e.addEventListener("change", (() => {
                this.active = e.value
            })), e.addEventListener("focus", (() => {
                this.active = e.value
            }));
            window.addEventListener("focus", (() => {
                t.includes(document.activeElement) || (this.active = void 0)
            }), !0)
        }
    }
}

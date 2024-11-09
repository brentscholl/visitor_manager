// radioGroup.js
export default function radioGroup({ initialCheckedIndex: defaultCheckedIndex = 0 } = {}) {
    return {
        value: undefined,       // Stores the currently selected radio button's value
        active: undefined,      // Stores the currently focused radio button's value

        // Initialize the radio group component
        init() {
            // Get all radio input elements within the component
            const radioInputs = Array.from(this.$el.querySelectorAll("input"));

            // Set the initial value based on the provided index or default to the first radio button
            this.value = radioInputs[defaultCheckedIndex]?.value;

            // Add event listeners to each radio input for `change` and `focus` events
            for (let radioInput of radioInputs) {
                // Update `active` and `value` when a radio button is selected
                radioInput.addEventListener("change", () => {
                    this.active = radioInput.value;
                    this.value = radioInput.value;
                });

                // Update `active` when a radio button receives focus
                radioInput.addEventListener("focus", () => {
                    this.active = radioInput.value;
                });
            }

            // Listen for focus events to reset `active` when focus moves outside the radio group
            window.addEventListener("focus", () => {
                if (!radioInputs.includes(document.activeElement)) {
                    this.active = undefined;
                }
            }, true);
        }
    };
}

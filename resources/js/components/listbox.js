// listbox.js
export default function listbox(e) {
    return {
        // Initialize the listbox component
        init() {
            // Set the number of options available in the listbox
            this.optionCount = this.$refs.listbox.children.length;
            // Watch for changes in activeIndex to update activeDescendant
            this.$watch("activeIndex", (index) => {
                if (this.open) {
                    this.activeDescendant = this.activeIndex !== null
                        ? this.$refs.listbox.children[this.activeIndex].id
                        : "";
                }
            });
        },

        // Properties to manage the listbox state
        activeDescendant: null, // The ID of the currently active option
        optionCount: null,      // The total number of options in the listbox
        open: false,            // Controls whether the listbox is open
        activeIndex: null,      // Index of the currently highlighted option
        selectedIndex: 0,       // Index of the currently selected option

        // Computed property: Returns the currently active option element
        get active() {
            return this.items[this.activeIndex];
        },

        // Computed property: Returns the currently selected option element
        get [e.modelName || "selected"]() {
            return this.items[this.selectedIndex];
        },

        // Selects an option by index and closes the listbox
        choose(index) {
            this.selectedIndex = index;
            this.open = false;
        },

        // Toggles the listbox open on button click, focusing on the current selection
        onButtonClick() {
            if (!this.open) {
                this.activeIndex = this.selectedIndex;
                this.open = true;
                this.$nextTick(() => {
                    this.$refs.listbox.focus();
                    this.$refs.listbox.children[this.activeIndex].scrollIntoView({ block: "nearest" });
                });
            }
        },

        // Selects the currently highlighted option
        onOptionSelect() {
            if (this.activeIndex !== null) {
                this.selectedIndex = this.activeIndex;
            }
            this.open = false;
            this.$refs.button.focus();
        },

        // Closes the listbox on pressing the Escape key
        onEscape() {
            this.open = false;
            this.$refs.button.focus();
        },

        // Navigates up through options, wrapping to the last option if at the top
        onArrowUp() {
            this.activeIndex = this.activeIndex - 1 < 0 ? this.optionCount - 1 : this.activeIndex - 1;
            this.$refs.listbox.children[this.activeIndex].scrollIntoView({ block: "nearest" });
        },

        // Navigates down through options, wrapping to the first option if at the bottom
        onArrowDown() {
            this.activeIndex = this.activeIndex + 1 > this.optionCount - 1 ? 0 : this.activeIndex + 1;
            this.$refs.listbox.children[this.activeIndex].scrollIntoView({ block: "nearest" });
        },

        // Spread operator to include any additional properties from the passed-in parameter
        ...e
    };
}

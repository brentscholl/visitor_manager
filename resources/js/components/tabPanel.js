// tabPanel.js
export default function tabPanel(defaultIndex) {
    return {
        selected: false, // Indicates if this panel is currently selected and visible

        // Initialize the tab panel component
        init() {
            // Get all tab panels within the same tabs container
            const panels = Array.from(this.$el.closest('[x-data^="Components.tabs("]').querySelectorAll('[x-data^="Components.tabPanel("]'));

            // Set `selected` to true if this panel's index matches the default index
            this.selected = panels.indexOf(this.$el) === defaultIndex;
        },

        // Handle custom "tab-select" events to update `selected` state
        onTabSelect(event) {
            // Set `selected` to true if this panel matches the selected panel in the event detail
            this.selected = event.detail.panel === this.$el;
        }
    };
}

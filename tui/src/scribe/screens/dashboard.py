"""Dashboard screen module."""

from textual.app import ComposeResult
from textual.screen import Screen
from textual.widgets import Static, DataTable, Button
from textual.containers import Vertical, Horizontal


class DashboardScreen(Screen):
    """Dashboard screen showing user data."""

    def compose(self) -> ComposeResult:
        """Create child widgets for the screen."""
        yield Vertical(
            Static("Dashboard", classes="title"),
            Static(f"Welcome, {self.app.current_user.get('name', 'User')}!" 
                   if self.app.current_user else "Welcome!"),
            DataTable(id="data_table"),
            Horizontal(
                Button("Refresh", id="refresh_button"),
                Button("Logout", id="logout_button"),
                classes="button_container",
            ),
            id="dashboard_container",
        )

    async def on_mount(self) -> None:
        """Called when screen is mounted."""
        await self.load_dashboard_data()

    async def load_dashboard_data(self) -> None:
        """Load data for the dashboard."""
        table = self.query_one("#data_table", DataTable)

        # Add columns
        table.add_columns("ID", "Name", "Status", "Actions")

        # Add sample rows (replace with actual API data)
        table.add_rows([
            ["1", "Item 1", "Active", "Edit | Delete"],
            ["2", "Item 2", "Inactive", "Edit | Delete"],
        ])

    async def on_button_pressed(self, event: Button.Pressed) -> None:
        """Handle button press events."""
        if event.button.id == "refresh_button":
            await self.load_dashboard_data()
        elif event.button.id == "logout_button":
            self.app.current_user = None
            await self.app.pop_screen()

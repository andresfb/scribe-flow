"""Home screen module."""

from textual.app import ComposeResult
from textual.screen import Screen
from textual.widgets import Static, Button
from textual.containers import Vertical, Horizontal


class HomeScreen(Screen):
    """Home screen of the application."""

    def compose(self) -> ComposeResult:
        """Create child widgets for the screen."""
        yield Vertical(
            Static("Welcome to Scribe", classes="title"),
            Horizontal(
                Button("Login", id="login_button", variant="primary"),
                Button("About", id="about_button"),
                classes="button_container",
            ),
            id="home_container",
        )

    async def on_button_pressed(self, event: Button.Pressed) -> None:
        """Handle button press events."""
        if event.button.id == "login_button":
            await self.app.push_screen("login")
        elif event.button.id == "about_button":
            # You can show an about dialog or screen
            pass

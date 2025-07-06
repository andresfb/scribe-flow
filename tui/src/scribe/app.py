"""Main application module."""

from textual.app import App, ComposeResult
from textual.containers import Container, Horizontal, Vertical
from textual.widgets import Header, Footer, Button, Static
from textual.binding import Binding

from .screens.home import HomeScreen
from .screens.login import LoginScreen
from .screens.dashboard import DashboardScreen
from .api.client import APIClient


class Scribe(App):
    """Main TUI Application."""

    CSS = """
    Screen {
        background: $surface;
    }

    .container {
        width: 100%;
        height: 100%;
        align: center middle;
    }

    #welcome {
        width: auto;
        height: auto;
        padding: 2 4;
        background: $primary;
        color: $text;
        border: heavy $background;
    }
    """

    BINDINGS = [
        Binding("q", "quit", "Quit", priority=True),
        Binding("h", "push_screen('home')", "Home"),
        Binding("l", "push_screen('login')", "Login"),
    ]

    SCREENS = {
        "home": HomeScreen,
        "login": LoginScreen,
        "dashboard": DashboardScreen,
    }

    def __init__(self):
        super().__init__()
        self.api_client = APIClient()
        self.current_user = None

    def compose(self) -> ComposeResult:
        """Create child widgets for the app."""
        yield Header(show_clock=True, name="Scribe")
        yield Container(
            Static("Welcome to Scribe!", id="welcome"),
            classes="container",
        )
        yield Footer()

    async def on_mount(self) -> None:
        """Called when app starts."""
        # You can perform initialization here
        await self.push_screen("home")

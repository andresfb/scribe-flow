"""Login screen module."""

from textual.app import ComposeResult
from textual.screen import Screen
from textual.widgets import Static, Button, Input, Label
from textual.containers import Vertical, Horizontal
from textual.validation import Length


class LoginScreen(Screen):
    """Login screen for user authentication."""

    def compose(self) -> ComposeResult:
        """Create child widgets for the screen."""
        yield Vertical(
            Static("Login", classes="title"),
            Label("Email:"),
            Input(
                placeholder="Enter your email",
                id="email_input",
                validators=[Length(minimum=3)],
            ),
            Label("Password:"),
            Input(
                placeholder="Enter your password",
                password=True,
                id="password_input",
                validators=[Length(minimum=8)],
            ),
            Horizontal(
                Button("Login", id="submit_button", variant="primary"),
                Button("Cancel", id="cancel_button"),
                classes="button_container",
            ),
            id="login_container",
        )

    async def on_button_pressed(self, event: Button.Pressed) -> None:
        """Handle button press events."""
        if event.button.id == "submit_button":
            await self.handle_login()
        elif event.button.id == "cancel_button":
            await self.app.pop_screen()

    async def handle_login(self) -> None:
        """Handle the login process."""
        email_input = self.query_one("#email_input", Input)
        password_input = self.query_one("#password_input", Input)

        email = email_input.value
        password = password_input.value

        if not email or not password:
            # Show error message
            return

        try:
            # Call API to authenticate
            result = await self.app.api_client.login(email, password)

            # Store the token and user info
            self.app.current_user = result.get("user")

            # Navigate to dashboard
            await self.app.push_screen("dashboard")

        except Exception as e:
            # Handle login error
            self.notify(f"Login failed: {str(e)}", severity="error")

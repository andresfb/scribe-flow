"""Entry point for the TUI application."""

import sys

from .app import Scribe


def main():
    """Main entry point."""
    app = Scribe()
    app.run()
    return 0


if __name__ == "__main__":
    sys.exit(main())

"""API client for communicating with the Laravel backend."""

import os
from typing import Optional, Dict, Any
import httpx
from dotenv import load_dotenv

load_dotenv()


class APIClient:
    """Client for API communication."""

    def __init__(self):
        self.base_url = os.getenv("API_BASE_URL", "http://localhost:8000/api")
        self.client = httpx.AsyncClient(
            base_url=self.base_url,
            timeout=30.0,
        )

    async def login(self, email: str, password: str) -> Dict[str, Any]:
        """Authenticate user."""
        response = await self.client.post(
            "/sanctum/token",
            json={"email": email, "password": password, "device_name": "scribe-tui"},
        )
        response.raise_for_status()
        return response.json()

    async def get_user_data(self, token: str) -> Dict[str, Any]:
        """Get user data."""
        response = await self.client.get(
            "/user",
            headers={"Authorization": f"Bearer {token}"},
        )
        response.raise_for_status()
        return response.json()

    async def get_dashboard_data(self, token: str) -> Dict[str, Any]:
        """Get dashboard data."""
        response = await self.client.get(
            "/dashboard",
            headers={"Authorization": f"Bearer {token}"},
        )
        response.raise_for_status()
        return response.json()

    async def close(self):
        """Close the HTTP client."""
        await self.client.aclose()

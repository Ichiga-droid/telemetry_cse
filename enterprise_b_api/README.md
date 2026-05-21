Enterprise B simple mock API

This small PHP API simulates the Enterprise B reactor data provider.

Endpoints:
- `GET /index.php` — returns generated sensor JSON
- `GET /index.php?mode=override` — returns the override state if set
- `POST /update.php` — set override JSON (body: JSON)
- `POST /reset.php` — reset override (delete stored state)

Run locally for testing:

```bash
cd enterprise_b_api
php -S localhost:5000
```

Notes:
- Data is generated on each request.
- Override state is stored in `state.json` and can be used to simulate compromised or injected data.
- Keep the code simple and procedural to match the main project style.

Diffs or patch files for this API can be stored in the `diffs/` folder.
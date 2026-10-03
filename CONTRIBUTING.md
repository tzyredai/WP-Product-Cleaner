# Contributing

Thanks for improving WP Product Cleaner.

1. Fork the repository and create a focused branch.
2. Keep destructive behavior opt-in and preserve the Trash-first safety model.
3. Sanitize input, escape output, use WordPress nonces/capabilities, and revalidate product state before mutations.
4. Run the local checks documented in `developer-tests/README.md`.
5. Describe the behavior change and safety implications in your pull request.

Please avoid adding telemetry, remote execution, hidden network calls or automatic deletion behavior.

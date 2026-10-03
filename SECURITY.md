# Security Policy

## Supported version

Security fixes are applied to the latest release of WP Product Cleaner.

## Reporting a vulnerability

Please **do not publish working exploit details, credentials, customer data or private site information in a public GitHub issue**.

For a suspected security issue, open a minimal issue at https://github.com/tzyredai/WP-Product-Cleaner/issues stating that you have a security report and describing only the affected version/component at a high level. A maintainer can then arrange an appropriate private channel before sensitive technical details are shared.

For ordinary bugs without sensitive information, a normal GitHub issue is appropriate.

## Security design notes

The plugin uses WordPress nonces, capability checks, per-product delete checks, exact match revalidation before mutation, Trash-first behavior, typed confirmation for permanent deletion, bounded request payloads and formula-safe CSV export. It intentionally does not expose raw unexpected exception details to browser clients.

# Security Policy

Quillwork is a WordPress FSE theme. We take security seriously — especially around PHP output escaping, file-path handling, and template safety.

We appreciate responsible disclosure and will treat good-faith reports seriously and respectfully.

---

## Supported Versions

Security fixes are prioritized for:

- the current public release
- the current development branch when the issue has not yet shipped

---

## How to Report a Vulnerability

Please **do not** open a public GitHub issue for security vulnerabilities.

Instead, report privately using one of these routes:

1. **GitHub private security reporting** at https://github.com/thisismyurl/quillwork/security/advisories/new
2. Email **security@thisismyurl.com** with a note that the report is security-sensitive

Please include:

- affected theme version
- WordPress version and PHP version
- steps to reproduce
- proof of concept if available
- impact assessment (what an attacker could do)
- whether authentication is required

---

## Response Targets

Our goals are:

- **Acknowledgement:** within 3 business days
- **Initial triage:** within 7 business days
- **Remediation plan:** as quickly as responsibly possible based on severity

These are targets, not guarantees, but we aim to communicate clearly throughout the process.

---

## Coordinated Disclosure

We support coordinated disclosure.

Please give us reasonable time to investigate and prepare a fix before publishing details publicly. In return, we will:

- acknowledge valid reports
- communicate clearly about severity and impact
- work toward a fix responsibly
- credit researchers where appropriate and desired

---

## Scope

Security issues for a WordPress theme may include:

- unsafe output escaping in PHP templates
- unsafe file-path handling or traversal
- CSRF vulnerabilities in any theme settings
- privilege escalation through theme capabilities
- XSS via template output or customizer
- insecure defaults that create serious user risk

---

## Our Security Principles

- **Safe by Default**
- **Privacy First**
- **Zero hidden external calls**
- **Least surprise for users**

See also: [`PILLARS.md`](PILLARS.md)

---

## Thank You

If you take the time to report a security issue responsibly, you are helping protect real WordPress site owners.

We appreciate that.

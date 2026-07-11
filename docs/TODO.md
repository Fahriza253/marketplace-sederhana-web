# Todo List — DriveHub Roadmap

Roadmap pengembangan berdasarkan audit codebase. DriveHub adalah **listing platform** (pembayaran di luar sistem). **Finance** = pelacakan lead/inquiry (WhatsApp), bukan payment gateway.

## Done

- [x] Logout function
- [x] Fix breadcrumbs

## Fase 1 — Stabilisasi (P0)

- [x] Fix RBAC (`hasRole`, register role, seed seller, gate create)
- [x] Align product status enum (`available` | `unavailable` | `sold`)
- [x] Fix dashboard route prefix
- [x] Persist vehicle fields + redirect create

## Fase 2 — UI/UX

- [x] Navbar + create shortcut + icons
- [x] Action confirmations
- [x] Login/register polish + phone
- [x] Search filters + empty state
- [x] Landing DriveHub
- [x] Primary color tokens
- [x] Seeder images

## Fase 3 — Dashboard & Finance

- [x] Seller/admin dashboard overview
- [x] Finance = WhatsApp lead tracking + seller phone CTA
- [x] Minimal feature tests

# Performance & Accessibility Baseline

This document tracks Lighthouse scores before and after the performance and accessibility improvements made in the final sprint (Days 8–11 of Phase 2).

## Methodology

- **Tool:** Chrome DevTools Lighthouse
- **Mode:** Navigation
- **Device:** Desktop
- **Environment:** Local development (LocalWP) — `http://localhost:10052`
- **Note:** Tested on local HTTP environment. Production deployment on HTTPS is expected to score equal or higher on Best Practices, since the HTTP-related warning will not apply.

## Baseline Scores — Before

Recorded: June 30, 2026

| Page | Performance | Accessibility | Best Practices | SEO |
|---|---|---|---|---|
| Home page | 100 | 93 | 96 | 85 |
| About Us page | 100 | 95 | 96 | 92 |

### Known issues identified in baseline scan

- **Reduce unused JavaScript** — Est. savings of 349 KiB (Home page)
- **Reduce unused CSS** — Est. savings of 45 KiB (Home page)
- **Links do not have a discernible name** — accessibility issue, affects screen reader users
- **2 long main-thread tasks** found on Home page

These issues are addressed in the accessibility and performance sprint (semantic HTML audit, ARIA labels, image lazy loading, CLS prevention).

## After Scores

_To be recorded after Day 11 (Image lazy loading + CLS prevention) — pending._

| Page | Performance | Accessibility | Best Practices | SEO |
|---|---|---|---|---|
| Home page | TBD | TBD | TBD | TBD |
| About Us page | TBD | TBD | TBD | TBD |

## Summary

Both pages already score strongly on Performance (100/100) thanks to the Vite build pipeline and per-layout scoped CSS/JS, which avoids loading unused styles or scripts on pages that don't need them. The accessibility and SEO improvements in this sprint target the specific issues flagged above — primarily ARIA labeling, semantic HTML structure, and link naming.

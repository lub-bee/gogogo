# GoGoGo — UI review & implied-feature inventory

Static snapshot of the public front end, branch `prod-backup-20260710`, generated 2026-08-10.
Scope: public site (`front/` views + `layouts/public`). The `/management` back office and the
Breeze auth pages are out of scope but referenced where they confirm an intended feature.

Legend — **[OK]** works today · **[DEAD]** visible but wired to nothing · **[STUB]** route exists,
screen is raw text · **[IMPLIED]** feature the UI/code strongly suggests but that doesn't exist yet.

---

## 1. Top page `/` (top.html)

### Global chrome
| Element | Status | Notes |
|---|---|---|
| Snap-scroll fullscreen sections (Top / Event / Agenda / About / Media / Topic) | OK | CSS scroll-snap + `scroll-smooth` |
| Right-side anchor menu (desktop ≥ lg only) | OK | IntersectionObserver highlights the active section and inverts menu color on dark sections |
| Favicons + webmanifest | OK | PWA-lite intent (`site.webmanifest`, android-chrome icons) |

### Section "Top"
| Element | Status | Notes |
|---|---|---|
| Slot-machine animated logo (五語Go) | OK | 3 slots, scripted rotation every 1.5 s (`resources/js/app.js`) |
| Login form (email / password / "sign in") | OK (needs backend) | POSTs to Breeze `login`; validation error slots (`x-input-error`) present |
| "Join us!" button | OK (needs backend) | → Breeze `register`; implies member signup feature |
| "You have forgot your password?" link | OK (needs backend) | → Breeze `password.request` |
| **Logged-in state** (not rendered in snapshot) | OK (auth) | Random greeting (GreetingsService, EN/JA), giant menu: Dashboard (admin only), Discord, Line, Profile, Logout |
| Discord panel (auth) | PARTIAL | "discord invitation" placeholder box + live Discord widget iframe (hard-coded server id) |
| LINE panel (auth) | DEAD | Two "line invitation" placeholder boxes — implies a LINE join/QR feature to build |

### Section "Event" (featured/upcoming event)
| Element | Status | Notes |
|---|---|---|
| Upcoming-event auto-selection | OK | Controller picks next published event, falls back to first published |
| "Prev" button | OK | Links to `previous()` event (conditional) |
| **"Next" button** | DEAD | Styled + hover animation, but it is a `<div>` with no link. Implied: navigate to next event |
| Calendar card (year / day / month) | OK | From `start_at` |
| **"Media" switcher** | DEAD | `@click="mode = 'media'"` but no `x-data` provides `mode` on this page. Implied: inline panel showing the event's photo gallery |
| **"Topic" switcher** | DEAD | Same. Implied: inline panel with the event's conversation topic (EN/JA) |
| **"Location" switcher** | DEAD | Same. Implied: inline panel with venue info/map (Location model exists) |
| **"I'm going" button** | DEAD | No handler at all. Implied: RSVP / attendance feature |
| Event title + EN & JA rich-text descriptions | OK | `description_en` / `description_ja` rendered as HTML (`formated-content` typography) |

### Section "Agenda"
| Element | Status | Notes |
|---|---|---|
| Month blocks (SEPT / OCT) with event tiles | **HARD-CODED** | 5 demo tiles written in the Blade file, not DB-driven. Implied: dynamic monthly agenda of published events |
| Per-tile icon (`fa-book`, `fa-mug-hot`) | HARD-CODED | Implies an "event type/category" concept (no such field surfaced elsewhere) |
| Tile links | OK-ish | Link to `/event/{slug}` with hard-coded slugs |
| "See all" button | STUB target | → `/agenda`, which renders `agenda!` (Blade TODOs: loop Month/Day/Title/Type/ID) |

### Section "About"
| Element | Status | Notes |
|---|---|---|
| 3 accordion questions (What is it / How does it work / That's all?) | OK | Alpine `mode` toggling, caret rotation, bilingual EN/JA |
| "Take a look!" button | OK | Anchor to `#media` (which is empty — see below) |

### Section "Media"
| Element | Status | Notes |
|---|---|---|
| Section body | **EMPTY** | Header only. Implied: photo/video gallery. Back office has Media CRUD + validation flow (`media.validate` ⇒ moderation) and `media-card`/`media-thumbnail` components — a front gallery is clearly intended |

### Section "Topic"
| Element | Status | Notes |
|---|---|---|
| Section body | **EMPTY** | Header only. Implied: list of conversation topics. Routes `/topic/{slug}` + `/topic/{slug}/download` exist ⇒ a **downloadable topic sheet** feature (TopicOutputController) |

---

## 2. Event show `/event/{slug}` (event-show.html)
Same building blocks as the Top "Event" section, plus:

| Element | Status | Notes |
|---|---|---|
| "Prev" navigation | OK | Conditional on `hasPrevious()` (recent commit added this) |
| "Next" navigation | DEAD | Same dead `<div>` as on Top |
| Media / Topic / Location / I'm going | DEAD | `mode` Alpine context missing → switchers inert (a `mode === 'default'` binding on `<main>`/`<nav>` suggests the intended behavior: clicking swaps the main panel) |
| Commented-out Blade blocks | IMPLIED | Cost display (`$event->cost`), separate date parts, topic/location ids — fields exist on the model, UI not built |

---

## 3. Stub screens (route + raw text only)
| Route | View output | Implied feature |
|---|---|---|
| `/events` | `EVENT INDEX` | Full event listing/archive |
| `/agenda` | `agenda!` | Dynamic agenda (Blade TODOs list Month, Day, Title, Type, ID) |
| `/topic/{slug}` | `TOPICSHOW` | Topic detail (EN/JA) + PDF/download output |
| `/location/{slug}` | `LOcation show` | Venue page (address, map…) |
| `/media/{id}` | `MEDIA SHOW` | Media/gallery detail |
| `/user/{id}` | `USERSHOW` | Public member profile |

---

## 4. Cross-cutting signals from the codebase
- **Auth & ranks**: Breeze auth + `rank:admin,support` middleware ⇒ member / support / admin roles.
- **Back office confirms intended entities**: Event, Topic, Location, Media (with `validated_at` moderation), Tag, User — full CRUDs under `/management`. Tags have no front UI at all yet ⇒ implied tag filtering/browsing.
- **Publishing workflow**: `publish` PATCH routes on Event/Topic + `isPublished()` scopes ⇒ draft/published states drive the front.
- **Bilingual content model**: `description_en` / `description_ja` everywhere ⇒ EN/JA duality is a core design intent.
- **`/temp/*` routes** (event, topic, location, media, agenda) ⇒ design-sandbox pages used during development.

## 5. Defects noticed while snapshotting
- `layouts/public.blade.php`: `class="top relativerelative …"` — typo (`relative` doubled).
- Alpine `:class="mode === 'default' …"` used on pages where no `x-data` defines `mode` (top event section, event-show) → Alpine warnings/inert bindings in prod.
- `x-event.responsive-related-card` is called with `media_id/topic_id/location_id` props on event-show and with `:event` on the top page — props are declared but never used inside the component.
- About section: stray `</b>` in the Japanese "how it works" grid (invalid HTML, browsers auto-recover).
- `about-section` first accordion has a leftover unused `x-data="{open: false}"`.

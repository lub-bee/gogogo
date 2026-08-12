# GoGoGo — Product brief & feature list (2026-08-10)

Brief dictated by Ludo, to hand over together with the static UI snapshot (`index.html`,
`UI-FEATURES.md`) for design work on the missing screens.

## Context
Small volunteer group practicing Japanese ↔ English language exchange. They meet every week
(sometimes several times a week) at an event. Each session has a discussion topic written in
advance by Daniel. Today the topic lives in a Google Doc whose link is shared on LINE —
offline reading is painful and publishing is a manual copy/paste chore for Daniel.

## Art direction — binding constraint
**The site's art direction is already decided.** The existing screens (top page and event
page — see the static snapshot) define it. All new/missing screens must **follow and
complete this direction**, not reinvent it.

### Description of the current design language
- **Typography as the interface.** Almost no imagery, borders or cards: hierarchy is carried
  by huge, ultra-bold, uppercase type (up to 10rem headers), with tight negative letter-spacing
  (`-0.12em`) and deliberately clipped line-heights — section headers overflow their container
  on purpose, giving a poster/editorial feel.
- **Font**: Figtree (300–600), sans-serif everywhere.
- **Palette**: flat and restrained — slate scale (slate-200/600/700/900) as the backbone,
  white, plus small accent touches: pink-200 (event navigation), sky-200 (related links),
  yellow-100 (hover states), blue/green/red only for action semantics (main/success/danger).
  Sections alternate light/dark backgrounds (white → slate-700 → slate-200 → slate-600 → blue-200).
- **Layout**: fullscreen snap-scroll sections (one concept per viewport), a fixed right-side
  anchor menu (desktop) that inverts its color on dark sections; content centered with
  generous emptiness, no grid of cards.
- **Motion & hover**: playful, type-driven — letter-spacing expands/contracts on hover
  (`.btn`, agenda tiles), menu links shift horizontally, the Prev/Next pink slabs rotate and
  squash on hover, the logo is a slot-machine animation cycling 五/5/ご/ゴ/Go. Transitions are
  `transition-all`, ~150–500 ms.
- **Bilingual duality as a visual motif**: EN and JA are always shown side by side or stacked,
  JA usually in a lighter tone (slate-500) and right-aligned — the two languages are part of
  the composition, not a language switcher.
- **Icons**: FontAwesome 6, used sparingly as inline markers (calendar-less date cards, list
  bullets, related-link markers).
- **Buttons**: no boxes — bare uppercase bold text that gains/loses tracking and swaps color
  on hover (`btn btn-main/success/danger`); form inputs are simple rounded slate-bordered
  fields.

## Features

### 1. Topics
- Topics readable on the site; each topic is bilingual: **English + Japanese**.
- Topics can be **downloaded**.
- Flexible formatting: keep something close to what Daniel produces in Google Docs — do NOT
  lock him into a rigid format. Open point: which formatting is supported vs the page design.
- Topics will be shared both on LINE and on this site.

#### Decided publishing architecture (Google Docs → site → LINE)
- Daniel keeps writing in Google Docs. A small **Apps Script deployed on his Drive** adds a
  menu to the Doc with three actions — **the buttons publish, they never ask questions**
  (no relational dialogs inside Docs):
  - **Publish topic** — direct publication, no draft step. The script exports the doc
    content (using Daniel's own OAuth token — no service account, no sharing) and POSTs it
    raw to a site API endpoint, authenticated by a secret token stored in Script Properties.
  - **Publish event** — same mechanism for an event's content.
  - **Check publication** — asks the site whether THIS doc has already been published
    (status, date, link to the page).
  - **Check formatting** — dry-run: the server validates the doc against the supported
    formatting and answers either "all supported ✓" or the list of elements that would be
    ignored, so Daniel can check before publishing.
- **Universal rule: anything requiring a selection happens in the admin panel, right after
  a redirect.** After publish, the script shows "Published ✓ — [Open in GoGoGo admin]"; the
  link opens the edit screen of the freshly created/updated entity, where pickers work on
  real data:
  - Event: **location picker** (autocomplete over the existing small venue referential,
    "create if missing" — no free-text location entry, to avoid duplicates) + date.
  - Topic: **event picker** (may default to the obvious candidate when exactly one upcoming
    event has no topic yet).
  - Daniel also sees the normalized rendering there — verification and linking in one stop.
- The script does **no conversion**: the **server** normalizes the messy Docs HTML through a
  whitelist, splits EN/JA, and stores the canonical content in DB.
  **Agreed whitelist** (validated with Daniel's actual usage): headings, bold, bullet
  lists, numbered lists, **tables**, text **colors**. Not supported: pasted images (he
  doesn't use them), indentations (he'll be told not to use them).
  Open design question on colors: keep them as-is inside topic content only
  (`formated-content` is "Daniel's zone"), or have the server **map free colors to the
  site's palette** (red → red-500, blue → blue-500, …). Recommendation: mapping — Daniel
  keeps his emphasis intent, the site keeps its visual coherence. Display, download file and LINE message are all
  generated from that canonical version (single source of truth; offline reading solved by
  the site itself).
- Publishing is **idempotent**: the Google doc ID is the key — re-publishing the same doc
  updates the entity, never duplicates it (fix in the Doc → click Publish again).
- On publish, the site pushes the **LINE notification** (Messaging API, bot in the group).
- **Data model**: Topic and Event are distinct, independently existing entities; the link is
  carried by the event (`events.topic_id` nullable, `events.location_id` nullable). A topic
  can have no event; an event can have no topic.

#### Topic screen — design reference (mockups in `design-refs/`)
The Topic show screen design exists (see `design-refs/topic-show.png` + the two hover
states). Key traits, to keep as-is:
- **Dark variant of the DA**: near-black navy background (darker than slate-900), muted
  slate-blue text — the "night" counterpart of the light pages.
- Giant multi-line topic title at the top, sentence case, light weight.
- **Close (✕)** top-right — the screen behaves as an overlay/reader you dismiss.
- **Dark/light toggle button**: the reader offers both a dark and a light mode. This toggle
  is **scoped to this modal only** — it never affects the rest of the site (the mockups show
  the dark mode; a light variant is to be designed).
- Left rail: **language tabs** ENGLISH / 日本語 (JA slightly indented) switching the content
  column — hover shows a skewed slab highlight (same parallelogram language as the event
  Prev/Next navigation).
- Left rail bottom: **DOWNLOAD** — hover expands into a rectangular slab revealing the full
  label "TOPIC DOWNLOAD".
- Content column: the normalized formatting scale — Title 1 / Subtitle / Subsubtitle /
  normal text, numbered lists, links, bold, underline, italic.

#### Topic section (top page) — design reference (`design-refs/topic-section.png`)
- **New section order on the top page**: Top → Event → Agenda → About → **Topic** → Media
  (Topic moves after About, before Media). The mockup's side menu also shows a **Location**
  entry at the end — a Location section on the top page is implied.
- Light background (near-white/slate-100), giant dark "TOPIC" header top-left.
- **VIEW ALL** as a giant type slab on a light-blue highlight, right-aligned, overlapping
  the header line.
- Topics shown as **staggered pink cards** (varied pink tints, two loose columns at
  irregular vertical offsets — no aligned grid): each card = topic title (truncated with
  "…") + EN excerpt and JA excerpt **side by side** (two-column bilingual preview,
  justified small text).
- Note: these cards are one deliberate exception to the "no cards" rule of the DA — flat
  color blocks, still borderless and shadowless.

### 2. Events
- List all events **in preparation or upcoming**.
- Each event carries its **location**, **date** and a **type**. Two event types:
  - **Gogogo** (regular language-exchange session) — book icon (`fa-book`)
  - **Special** (BBQ, festival, outing…) — café icon (`fa-mug-hot`)
  (These are the two icons already hard-coded in the current agenda section.)
- **One single Agenda screen**: `/events` is not a separate design — it is the Agenda with
  a type filter applied (e.g. All / Gogogo / Special).
- **RSVP**: any user with an account can say they're going ("I'm going").

### 3. Media / images
- **Registered & confirmed** users can upload images of an event.
- **Moderation**: a group of moderators accepts or refuses one or several images — the action
  must be dead simple.
- Refused image → **deleted** (only a thumbnail is kept).
- **Automatic resizing** of every upload to a reasonable, web-optimized size (40 MB camera
  photos must never hit the site) — **WebP** is the envisioned format.

### 4. Locations
- Simply a **Google Maps link/pin**: address or exact position, either way.

### 5. Comments
- For active members: **option kept open, nothing for now** (decision deferred).

### 6. LINE / Discord integrations
- For **active & confirmed** users only: access to the LINE and Discord plugins (view both
  communities/accounts).
- To verify: is the Discord server still active?

### 7. Member profile area (existing screens + requested changes)
Screenshots of the current screens are in `design-refs/` (top-logged-in, profile-overview,
profile-myinfo, profile-mypassword, profile-myaccount — all `-current`). The area is a
snap-scroll sequence with its own side menu (BACK / PROFILE / MY MEDIA / MY INFO / MY PWD /
MY ACCOUNT), technically behaving as a modal over the site.

- **Top page, logged-in state** (`top-logged-in.png`): JA/EN random greeting + round SNS
  buttons (home / Discord / LINE / logout) + GO TO DASHBOARD / GO TO PROFILE giant links.
- **Profile overview**: currently two bordered tables PUBLIC / PRIVATE — **judged ugly**.
  Requested: a giant page title like the other screens, and a **vertical separation**
  between the public and private halves instead of tables. (Public: pseudo, registered
  since, media published, participations. Private: email + links MEDIA / EDIT INFO /
  EDIT PWD / DELETION.)
- **My Media**: must list **all media the user submitted, with their status**. Refused
  media appear **greyed out** — only their thumbnail is kept and displayed (originals of
  refused images are deleted).
- **My Info** (edit): currently incomplete and rough (Name + Email + SAVE on dark blue).
  Requested: redesign, plus **per-field visibility control** (LINE pseudo / public name) —
  **all info is private by default**, the member chooses what becomes public.
- **My Password**: display the **new-password conditions/rules** on the screen (currently
  just a sentence "use uppercase, lowercase and numbers" — make the actual constraints
  explicit, ideally checked live).
- **My Account** (`profile-myaccount-current.png`): full-red danger section with giant
  warning copy and DELETE ACCOUNT — kept as is.

## Open points
- Exact supported formatting for topics (Google Docs fidelity vs page design).
- Google Docs → site publishing tool (secret credential).
- Comments feature (deferred).
- Discord server status.

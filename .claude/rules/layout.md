# Layout — Bootstrap grid, containers, and the page-assembly contract

Everything here is verified against this repo. The `wp:post-content`-without-container gap and the
`<h1>` duplication below are both bugs that actually shipped once here and were only caught by
measuring the rendered box in a browser, never by looking at a screenshot.

## Bootstrap 5.3.2, partially imported — know what's actually available

`package.json` pins `bootstrap: 5.3.2`, and `assets/src/styles/theme.scss` imports **individual
Sass files, not the whole framework**: `root`, `utilities`, `reboot`, `type`, `containers`, `grid`,
`helpers`, `utilities/api`, `card`, `forms`, `spinners`, `buttons`, `alert`. Anything not on that
list has no CSS in this theme — `badge`, `navbar`, `nav`, `breadcrumb`, `progress`, `modal`,
`table` and the rest are absent. Using such a class produces unstyled markup that silently looks
broken; either add the import deliberately or write scoped styles under your own root class.

JS is the same story: `Handlers\Front::enqueueBootstrap()` registers only the hand-picked modules
in `assets/src/js/bootstrap/` (`alert`, `collapse`, `dropdown`, `offcanvas`) — not the full bundle.

## `.container` is capped at 1280px, at every breakpoint from `xl` up

`assets/src/styles/custom_bootstrap/_custom_variables.scss` overrides the map down to a single
entry:

```scss
$container-max-widths: (
  xl: 1280px
);
```

There is **no `xxl` entry**, so a `.container` is 1280px wide on a 1440px viewport and still
1280px on a 2560px one. When you compute an expected width for anything inside a container, start
from 1280px, not from the viewport width.

## The grid blocks and what they emit

| Block | Emits | Notes |
| --- | --- | --- |
| `starter-kit/section` | the bare tag from `modification.tagName` (`main`, `section`, ...) | **No container, no padding** — it is a semantic wrapper only |
| `starter-kit/container` | `div.container` | The only block that gives you Bootstrap's centered, max-width, gutter-padded box |
| `starter-kit/row` | `div.row` (+ `justify-content-*` / `align-items-*` / `row-cols-*`) | |
| `starter-kit/column` | `div.col` / `.col-auto` / `.col-{n}` / `.col-{bp}-{n}` (`blocks/Column/src/index.jsx`) | `block.json` sets `"parent": ["starter-kit/row"]` — a column is only insertable inside a row |

`Container`/`Row`/`Column` are **static** blocks — no `render_callback`, the markup above is baked
into post content at save time. What you see in the post HTML is exactly what ships.

## `wp:post-content` gets no container — in any template

Every template in `templates/` wraps the page in `starter-kit/section` with `tagName: main`, and
that is a bare `<main>`. **Not one of the eight templates puts `wp:post-content` inside a
`starter-kit/container`.** Verified across `page.html`, `page-with-hero.html`,
`page-without-title.html`, `front-page.html`, `home.html`, `index.html`, `single.html`, `404.html`
— the container, where one exists at all, wraps the *hero/title* area only (`single.html`,
`page-with-hero.html`, `404.html`), never the content.

Consequence: **the page content itself is responsible for its own container.** If you edit a page's
content and remove its outermost `starter-kit/container`, the remaining paragraphs and buttons go
flush against the left edge of the viewport with zero padding. This has happened; it is not a
theoretical risk. Either keep a `starter-kit/container` as the content's outermost block, or use a
block that renders its own — check whatever added the block (this theme's own `blocks/`, or a
plugin's) for whether its root element already includes one.

## `<h1>` comes from the template — don't type a second one into the content

`page.html` and `page-with-hero.html` both render `<!-- wp:post-title {"level":1} -->`. The page
title is therefore already an `<h1>` on the rendered page, before any content block runs.

Adding an `<h1>` heading inside the page content stacks two titles with different alignment. This
is an **editorial** failure mode, not a code one — it arrives by duplicating an existing page
through wp-admin or `wp post create`, where the content carries a heading that belonged to a
template that didn't render the title. Two ways out, pick per page:

- Content has no `<h1>` of its own → use `page.html` (default) or `page-with-hero.html`.
- Content owns its own `<h1>` → assign the **`page-without-title.html`** custom template, which
  renders `wp:post-content` alone. It exists precisely for this.

Whenever you create or copy a page's content, check which of the two cases it is before saving.

## The double width squeeze — a mechanical risk of this grid, not (yet) a shipped bug here

A Bootstrap column takes a **percentage of its parent**, not of the viewport. Since `.container`
here is capped at 1280px (see above), any `col-*` inside it already renders as a fraction of
1280px — and nesting a second `max-width`-carrying ancestor (another `.container`, or any custom
class from this theme's own SCSS) inside the first multiplies the two caps instead of adding
width. The grid-blocks table above matters here: more than one block can end up emitting
`div.container` on the same page, so "did I nest a container" isn't always obvious just from the
block names shown in the editor.

Before adding a `col-*` anywhere in this theme's own templates/patterns:

1. Does any ancestor carry a `max-width` — Bootstrap's own `.container`, or a custom one in this
   theme's SCSS? Grep for it.
2. Is the ancestor already a `.container`, or a block from the table above that renders one?

If the answer to either is yes, use `col-12` (or no column at all) and let the constraining
ancestor do the sizing.

## Before calling a layout fix done — measure it

A screenshot confirms that something rendered. It does not confirm the size it rendered at, and
every layout bug listed on this page survived a screenshot review. Load the page in the browser
tooling and read the numbers:

```js
// width actually rendered
document.querySelector('.your-target').getBoundingClientRect()
// the constraint that produced it
getComputedStyle(document.querySelector('.your-target').parentElement).maxWidth
// anything hanging off the left edge
[...document.querySelectorAll('main *')]
  .filter(el => el.getBoundingClientRect().left <= 0)
```

Do it at 1440 / 768 / 375px, not just at whatever width the window happens to be. Report the
number against the number you expected — the expected value is derivable: 1280px container, minus
gutters, times the column fraction, minus any ancestor `max-width`.

# Developer HowTo's

This component is based heavily on the accordion component provided by the [U.S. web design standards](https://standards.usa.gov/components/accordions/).

## Helpers

### Show or hide single items

Create small helper functions to show and hide single items:

```js
showItem ($button) {
  this.toggleItem($button, false)
}
```

```js
hideItem ($button) {
  this.toggleItem($button, true)
}
```

## Variants

### Multiselectable

You can allow multiple sections to remain open at the same time by adding the `aria-multiselectable="true"` attribute to the component.

```
<div is="flynt-accordion-vertical" aria-multiselectable="true" class="flyntComponent">
  <!-- ... -->
</div>

```

## Accessibility

- Each button has a unique name aria-controls="id" that associates the control to the appropriate region by referencing the controlled element’s id.

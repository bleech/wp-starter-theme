import $ from 'jquery'

class AccordionVertical extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.setOptions()
    self.resolveElements()
    return self
  }

  setOptions () {
    this.aria = {
      hidden: 'aria-hidden',
      controls: 'aria-controls',
      expanded: 'aria-expanded'
    }
    this.class = {
      expanded: 'accordionVertical-item-isExpanded',
      hidden: 'accordionVertical-item-isHidden',
      contentIsSizing: 'accordionVertical-content-isSizing'
    }
    this.isMultiselectable = this.$.attr('aria-multiselectable')
  }

  resolveElements () {
    this.$item = $('.accordionVertical-item', this)
    this.$button = $('.accordionVertical-btn[aria-controls]', this)
    this.$content = $('.accordionVertical-content', this)
  }

  connectedCallback () {
    this.$.on('click', this.$button.selector, this.toggleButton)
    $(window).on('load resize', this.updateExpandedItemHeight)
  }

  /**
   * Toggle item state for clicked button.
   */
  toggleButton = (e, expanded) => {
    e.preventDefault()
    const $button = $(e.currentTarget)
    this.toggleItem($button, expanded)
  }

  /**
   * Toggle an item's "expanded" state, optionally providing a target
   * state.
   *
   * @param {HTMLButtonElement} button
   * @param {boolean?} expanded If no state is provided, the current
   * state will be toggled (from false to true, and vice-versa).
   * @return {boolean} the resulting state.
   */
  toggleItem ($button, expanded) {
    const id = $button.attr(this.aria.controls)
    const $item = $button.closest(this.$item.selector)
    const $content = $(`#${id}`, this)

    if (!$content.length) {
      throw new Error(
        `No content target found with id: ${id}`
      )
    }

    // Check if expanded state provided as parameter
    if (typeof expanded !== 'boolean') {
      expanded = $button.attr(this.aria.expanded) === 'true'

      // Reset state of all items if not multiselectable
      if (!this.isMultiselectable) {
        this.hideItems(this.$button)
      }
    }

    // Set new expanded state
    expanded = !expanded

    // Apply new state to target item
    $button.attr(this.aria.expanded, expanded)
    $content.attr(this.aria.hidden, !expanded)

    if (expanded) {
      $content.height($content.get(0).scrollHeight)
      $item
        .addClass(this.class.expanded)
        .removeClass(this.class.hidden)
    } else {
      $content.height('')
      $item
        .removeClass(this.class.expanded)
        .addClass(this.class.hidden)
    }

    return expanded
  }

  /**
   * Hide accordion items.
   *
   * @param {HTMLButtonElement} $buttons The buttons to hide.
   */
  hideItems ($buttons) {
    $.each($buttons, (i, button) => {
      this.toggleItem($(button), true)
    })
  }

  /**
   * Update the height of all expanded items
   * without triggering an animation.
   */
  updateExpandedItemHeight = () => {
    const expandedItems = this.$.find(`.${this.class.expanded}`)
    $.each(expandedItems, (i, item) => {
      const $content = $(item).find(this.$content.selector)
      $content
        .addClass(this.class.contentIsSizing)
        .height(0)
        .height($content.get(0).scrollHeight)

      clearTimeout(this.sizingTimeout)
      this.sizingTimeout = setTimeout(() => {
        this.$content.removeClass(this.class.contentIsSizing)
      }, 150)
    })
  }
}

window.customElements.define('flynt-accordion-vertical', AccordionVertical, {extends: 'div'})

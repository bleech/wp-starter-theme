# Documentation Structure

## Theme
0. On the Website:
  1. Philosophy (Why?)
  - What does it do? (Short Code example)
  - For whom is this? (WP Devs?)
  - How to get started (links to theme docs)
1. Theme Docs: Introduction
  1. Requirements / What do I need? / What do I need to know?
    - A. Use Trellis, ScotchBox or whatever or:
    - B. set it up yourself
      - node (version?)
      - composer
      - yarn / npm (version?)
      - php (version?)
      - mysql (version?)
      - (opt.) phpcs (if you want to test / for developing the boilerplate | theme only)
  - Setting up the project (+ installing plugins)
    1. git clone or copy the boilerplate repo
    - composer install (in boilerplate)
      - also installs sub packages (currently submodules) theme and plugins
    - create db
    - install wordpress via UI (install.php)
- [TBD] Explain Theme Folder Structure
- Getting Started (Example)
  1. Theme Setup / Start
    - yarn (in theme) -> should this be automatic? after composer install?
    - npm start
  - [TBD] Tutorial: Building a Post Teaser List Module
    1. Creating a page template (default.js config and then page.php)
    - [TBD] Adding an area to the template and a module to the config
    - Creating the Module Folder (with `<?php echo 'hello world'; ?>` in index.php)
    - Adding ACF Fields (with ACF Light)
      - Adding Fields to the module (fields.json)
      - Adding a Field Group (pageModules.json)
    - Adding Content and displaying it using `$data()`
    - Adding a DataFilter (+ Arguments)
    - Modifying Data in the module's functions.php
    - Adding script.js and style.css
    - [TBD] Adding Dependencies (slick-carousel?)
    - Adding static assets (images, svgs, icons?, fonts?)
  - Recap of the tutorial and Further Reading
    - Advanced Features
    - ACF Link?
- Advanced Features
  1. Adding dynamic Submodules
  - Using Flexible Content (ACF Pro)
  - Using Repeaters (Pug + ACF Pro)
  - Custom Data
  - Custom Post Types
  - [TBD] Options Pages
- FAQ
- [opt] References?

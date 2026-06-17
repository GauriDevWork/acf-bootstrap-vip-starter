/**
 * Main JS entry point
 * Vite bundles this into assets/dist/js/main.js
 * CSS is imported here so Vite extracts it into assets/dist/css/main.css
 */

// Import SCSS — Vite compiles and extracts to dist/css/main.css
import '../src/main.scss';

// Bootstrap JS — import only what we use (tree-shaking)
import { Collapse } from 'bootstrap';
import { Dropdown } from 'bootstrap';
import { Modal } from 'bootstrap';
import { Offcanvas } from 'bootstrap';

// Make available globally for inline scripts
window.bootstrap = { Collapse, Dropdown, Modal, Offcanvas };
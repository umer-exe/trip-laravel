/**
 * Main Application Script
 * 
 * Entry point for Vite build process.
 * Imports and initializes global dependencies like Alpine.js and Axios.
 * Also imports feature-specific modules (cart, search).
 */

import './bootstrap';
import './cart';
import './search'; // AJAX live search functionality

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

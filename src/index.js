import "../css/style.scss"

import OpenStreetMap from "./modules/OpenStreetMap"
import MobileMenu from "./modules/MobileMenu"
import HeroSlider from "./modules/HeroSlider"
import Search from "./modules/Search"

const mobileMenu = new MobileMenu()
const heroSlider = new HeroSlider()
const headerSearch = new Search('.js-search-trigger', 'header-search-overlay-close', 'search-overlay', 'header-search-input', 'search-overlay-results')

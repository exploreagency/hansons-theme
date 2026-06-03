import Alpine from "alpinejs";
import collapse from "@alpinejs/collapse";

import "./carousel/carousel";

window.Alpine = Alpine;

Alpine.plugin( collapse );

Alpine.start();

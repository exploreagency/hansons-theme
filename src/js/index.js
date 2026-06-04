import Alpine from "alpinejs";
import collapse from "@alpinejs/collapse";

import "./carousel/carousel";
import schedulerFormModal from "./form/scheduler-form-modal";
import disclosureModal from "./modals/disclosure-modal";

window.Alpine = Alpine;

Alpine.plugin( collapse );

Alpine.data( 'disclosureModal', disclosureModal );
Alpine.data( 'schedulerFormModal', schedulerFormModal );

Alpine.start();

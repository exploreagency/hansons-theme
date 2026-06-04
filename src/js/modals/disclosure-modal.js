export default function disclosureModal() {
	return {
		isOpen: false,
		previousActiveElement: null,

		init() {
			this.bindTriggerClicks();
		},

		bindTriggerClicks() {
			this.$root.addEventListener('click', (event) => {
				const trigger = event.target.closest('.js-disclosure-modal-trigger');

				if (!trigger) {
					return;
				}

				event.preventDefault();
				this.openModal();
			});
		},

		openModal() {
			this.previousActiveElement = document.activeElement;
			this.isOpen = true;

			document.body.classList.add('disclosure-modal-is-open');

			this.$nextTick(() => {
				if (this.$refs.modalPanel) {
					this.$refs.modalPanel.setAttribute('tabindex', '-1');
					this.$refs.modalPanel.focus({ preventScroll: true });
				}
			});
		},

		closeModal() {
			this.isOpen = false;

			document.body.classList.remove('disclosure-modal-is-open');

			this.$nextTick(() => {
				if (
					this.previousActiveElement &&
					typeof this.previousActiveElement.focus === 'function'
				) {
					this.previousActiveElement.focus({ preventScroll: true });
				}
			});
		},
	};
}
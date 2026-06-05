(function () {
	const APPOINTMENT_DURATION_MINUTES = 90;
	const MAX_ATTEMPTS = 50;
	const INTERVAL_MS = 100;

	let attempts = 0;

	function initSchedulerThankYou() {
		attempts++;

		const thankYouBlock = document.querySelector('.js-scheduler-thank-you');

		if (!thankYouBlock) {
			if (attempts < MAX_ATTEMPTS) {
				setTimeout(initSchedulerThankYou, INTERVAL_MS);
			}

			return;
		}

		const params = new URLSearchParams(window.location.search);

		const firstName = params.get('first_name') || '';
		const appointmentDate = params.get('appointment_date') || '';
		const appointmentTime = params.get('appointment_time') || '';

		const firstNameEl = thankYouBlock.querySelector('.js-thank-you-first-name');
		const dateEl = thankYouBlock.querySelector('.js-thank-you-date');
		const timeEl = thankYouBlock.querySelector('.js-thank-you-time');

		const addToCalendarButton = thankYouBlock.querySelector('.js-add-to-calendar');
		const addToGoogleCalendarButton = thankYouBlock.querySelector(
			'.js-add-to-google-calendar'
		);

		if (firstNameEl) {
			firstNameEl.textContent = firstName;
		}

		if (dateEl) {
			dateEl.textContent = appointmentDate;
		}

		if (timeEl) {
			timeEl.textContent = appointmentTime;
		}

		if (!appointmentDate || !appointmentTime) {
			hideCalendarButtons(addToCalendarButton, addToGoogleCalendarButton);
			return;
		}

		const appointmentStart = parseAppointmentDateTime(
			appointmentDate,
			appointmentTime
		);

		if (!appointmentStart) {
			hideCalendarButtons(addToCalendarButton, addToGoogleCalendarButton);
			return;
		}

		const appointmentEnd = new Date(
			appointmentStart.getTime() + APPOINTMENT_DURATION_MINUTES * 60 * 1000
		);

		const eventTitle = 'Hansons Free Estimate Appointment';
		const eventDescription =
			'Your Hansons free estimate appointment is scheduled. Please set aside 60-90 minutes for the appointment.';
		const eventLocation = '';

		const googleCalendarUrl = buildGoogleCalendarUrl({
			title: eventTitle,
			description: eventDescription,
			location: eventLocation,
			startDate: appointmentStart,
			endDate: appointmentEnd,
		});

		const icsFile = buildIcsFile({
			title: eventTitle,
			description: eventDescription,
			location: eventLocation,
			startDate: appointmentStart,
			endDate: appointmentEnd,
		});

		if (addToGoogleCalendarButton) {
			addToGoogleCalendarButton.href = googleCalendarUrl;
		}

		if (addToCalendarButton) {
			const blob = new Blob([icsFile], {
				type: 'text/calendar;charset=utf-8',
			});

			const icsUrl = URL.createObjectURL(blob);

			addToCalendarButton.href = icsUrl;
			addToCalendarButton.download = 'hansons-appointment.ics';
		}
	}

	function hideCalendarButtons(addToCalendarButton, addToGoogleCalendarButton) {
		if (addToCalendarButton) {
			addToCalendarButton.hidden = true;
		}

		if (addToGoogleCalendarButton) {
			addToGoogleCalendarButton.hidden = true;
		}
	}

	function parseAppointmentDateTime(dateString, timeString) {
		const dateParts = dateString.split('/');

		if (dateParts.length !== 3) {
			return null;
		}

		const month = Number(dateParts[0]);
		const day = Number(dateParts[1]);
		const year = Number(dateParts[2]);

		const timeMatch = timeString.match(/^(\d{1,2}):(\d{2})\s?(AM|PM)$/i);

		if (!timeMatch) {
			return null;
		}

		let hours = Number(timeMatch[1]);
		const minutes = Number(timeMatch[2]);
		const meridiem = timeMatch[3].toUpperCase();

		if (meridiem === 'PM' && hours !== 12) {
			hours += 12;
		}

		if (meridiem === 'AM' && hours === 12) {
			hours = 0;
		}

		return new Date(year, month - 1, day, hours, minutes, 0);
	}

	function buildGoogleCalendarUrl({
		title,
		description,
		location,
		startDate,
		endDate,
	}) {
		const baseUrl = 'https://calendar.google.com/calendar/render';

		const params = new URLSearchParams({
			action: 'TEMPLATE',
			text: title,
			details: description,
			location: location,
			dates: `${formatGoogleDate(startDate)}/${formatGoogleDate(endDate)}`,
		});

		return `${baseUrl}?${params.toString()}`;
	}

	function buildIcsFile({ title, description, location, startDate, endDate }) {
		const uid = `${Date.now()}@hansons.com`;
		const now = new Date();

		return [
			'BEGIN:VCALENDAR',
			'VERSION:2.0',
			'PRODID:-//Hansons//Scheduler//EN',
			'CALSCALE:GREGORIAN',
			'METHOD:PUBLISH',
			'BEGIN:VEVENT',
			`UID:${uid}`,
			`DTSTAMP:${formatIcsDate(now)}`,
			`DTSTART:${formatIcsDate(startDate)}`,
			`DTEND:${formatIcsDate(endDate)}`,
			`SUMMARY:${escapeIcsText(title)}`,
			`DESCRIPTION:${escapeIcsText(description)}`,
			`LOCATION:${escapeIcsText(location)}`,
			'END:VEVENT',
			'END:VCALENDAR',
		].join('\r\n');
	}

	function formatGoogleDate(date) {
		return [
			date.getFullYear(),
			pad(date.getMonth() + 1),
			pad(date.getDate()),
			'T',
			pad(date.getHours()),
			pad(date.getMinutes()),
			'00',
		].join('');
	}

	function formatIcsDate(date) {
		return [
			date.getUTCFullYear(),
			pad(date.getUTCMonth() + 1),
			pad(date.getUTCDate()),
			'T',
			pad(date.getUTCHours()),
			pad(date.getUTCMinutes()),
			pad(date.getUTCSeconds()),
			'Z',
		].join('');
	}

	function pad(value) {
		return String(value).padStart(2, '0');
	}

	function escapeIcsText(value) {
		return String(value || '')
			.replace(/\\/g, '\\\\')
			.replace(/;/g, '\\;')
			.replace(/,/g, '\\,')
			.replace(/\n/g, '\\n');
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initSchedulerThankYou);
	} else {
		initSchedulerThankYou();
	}
})();
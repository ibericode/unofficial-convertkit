import { __ } from '@wordpress/i18n';

window.addEventListener('load', async () => {
	const indicator = document.getElementById('uck-indicator');
	const response = await fetch(
		`${window.ajaxurl}?action=unofficial_convertkit_info`
	);
	const { status, account, message } = await response.json();

	const state = {
		class: 'error',
		text: __('Not connected', 'unofficial-convertkit'),
	};

	switch (status) {
		//Status neutral
		case 0:
			state.class = 'neutral';
			break;
		//Status connected
		case 1:
			state.class = 'success';
			state.text = __('Connected', 'unofficial-convertkit');
			break;
	}

	indicator.classList.replace('neutral', state.class);
	indicator.textContent = state.text;

	const uckStatusInfo = document.getElementById('uck-status-info');

	if (false !== account && message.length === 0) {
		uckStatusInfo.innerText = `${__('as', 'unofficial-convertkit')} ${
			account.name ?? account.primary_email_address
		} `;

		return;
	}

	uckStatusInfo.classList.add('status-message');
	uckStatusInfo.innerText = message;
});

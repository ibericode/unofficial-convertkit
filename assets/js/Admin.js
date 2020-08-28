import { __ } from '@wordpress/i18n';

window.addEventListener('load', async () => {
	const indicator = document.getElementById('uck-indicator');
	const url = window.wp.ajax.settings.url;
	const response = await fetch(`${url}?action=unofficial_convertkit_info`);
	const { status, account } = await response.json();

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

	if (false === account) {
		document.getElementById('uck-account-status-text').innerText = __(
			'No information about your account.',
			'unofficial-convertkit'
		);
		return;
	}

	document.getElementById('uck-account-status').style.display = 'none';
	document.getElementById('uck-account-info').style.removeProperty('display');
	document.getElementById('uck-account-name').innerText = account.name ?? '';
	document.getElementById('uck-account-email').innerText =
		account.primary_email_address ?? '';
});

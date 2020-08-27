import { __ } from '@wordpress/i18n';

window.addEventListener('load', async () => {
	const indicator = document
		.getElementById('uck-indicator')
		.querySelector('.status-indicator');
	const url = window.wp.ajax.settings.url;
	const response = await fetch(
		`${url}?action=unofficial_convertkit_test_connection`
	);
	const { status } = await response.json();

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
});

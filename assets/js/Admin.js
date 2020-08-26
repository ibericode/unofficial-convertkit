import { __ } from '@wordpress/i18n';

const STATUS_NEUTRAL = 0;
const STATUS_CONNECTED =  1;

window.onload = async () => {

    const indicator = document.getElementById( 'uck-indicator' ).querySelector('.status-indicator');
    const url = window.wp.ajax.settings.url;
    const response = await fetch(`${url}?action=unofficial_convertkit_test_connection`);
    const { status } = await response.json();

    const state = {
        class: 'error',
        text: __( 'Not connected', 'unofficial-convertkit')
    };

    switch (status) {
        case STATUS_NEUTRAL:
            state.class = 'neutral';
            break;
        case STATUS_CONNECTED:
            state.class = 'success';
            state.text = __( 'Connected', 'unofficial-convertkit')
            break;
    }

    indicator.classList.replace('neutral', state.class);
    indicator.textContent = state.text;
}
import { hot } from 'react-hot-loader/root';
import React from 'react';

const Save = ({ attributes }) => {
	const { formUid } = attributes;

	if (!formUid) {
		//Don't show anything if the formUid is empty
		return null;
	}

	return <div>{`[unofficial-convertkit-forms id="${formUid}"]`}</div>;
};

export default hot(Save);

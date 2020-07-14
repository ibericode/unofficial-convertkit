const Save = ({ attributes }) => {
	const { formUid } = attributes;

	if (!formUid.length > 0) {
		//Don't show anything if the formUid is empty
		return null;
	}

	return `[unofficial-convertkit-forms id="${formUid}"]`;
};

export default Save;

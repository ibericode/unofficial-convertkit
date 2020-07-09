import { hot } from 'react-hot-loader/root';
import React from 'react';
import ConvertKitForm from 'convertkit-react';

const Edit = () => {
	//Todo: make the parameter configurable
	return <ConvertKitForm formId="1441335" template="charlotte" />;
};

export default hot(Edit);

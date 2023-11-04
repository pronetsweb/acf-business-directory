const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const package = require("./package.json");
const path = require( 'path' );

const entry = {};
[ 'plugin-public' ].forEach(
	( script ) =>
		( entry[ script ] = path.resolve(
			process.cwd(),
			`assets/src/${ script }.js`
		) )
);

module.exports = {
	...defaultConfig,
	entry,
	output: {
		path: path.join( __dirname, './assets/build' ),
	},
	externals: {
		react: 'React',
		'react-dom': 'ReactDOM',
	},
	plugins: [
	]
};

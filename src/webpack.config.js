const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const package = require("./package.json");
const path = require( 'path' );
const CopyPlugin = require("copy-webpack-plugin");

const entry = {};
[ 'plugin-public', 'business-field/index' ].forEach(
	( script ) =>
		( entry[ script ] = path.resolve(
			process.cwd(),
			`assets/src/${ script }.js`
		) )
);

const copy_files = [];
[ 'business-field/block' ].forEach(
        ( json ) =>
                copy_files.push( { from: path.join(
                        __dirname,
                        `assets/src/${ json }.json`
                ), to: path.join(
                        __dirname,
                        `assets/build/${ json }.json`
                ) } )
)

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
        plugins: defaultConfig.plugins.concat([
                new CopyPlugin({
                    patterns: copy_files
                }),
        ]),

};

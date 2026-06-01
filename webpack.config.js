const path = require("path");
const glob = require("glob");
const RemoveEmptyScriptsPlugin = require("webpack-remove-empty-scripts");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");

const isPartial = ( file ) => path.basename( file ).startsWith( "_" );

function getEntries() {
  const entries = {
    "js/output": "./src/js/index.js",
    "css/style": "./src/scss/output.scss",
  };

  glob.sync( "./blocks/**/src/*.js" ).forEach( file => {
    if ( isPartial( file ) ) return;

    const base  = path.basename( file, ".js" );
    
    entries[`js/blocks/${ base }`] = `./${ file }`;
  });

  glob.sync("./blocks/**/src/*.scss").forEach( file => {
    if ( isPartial( file ) ) return;

    const base  = path.basename( file, path.extname( file ) );

    entries[`css/blocks/${ base }`] = `./${ file }`;
  });

  return entries;
}

module.exports = {
  mode: "production",
  entry: getEntries(),
  output: {
    path: path.resolve( __dirname, "dist" ),
    filename: "[name].min.js",
    clean: true,
  },
  module: {
    rules: [
      { test: /\.js$/, exclude: /node_modules/, use: "babel-loader" },
      {
        test: /\.s?css$/,
        use: [MiniCssExtractPlugin.loader, "css-loader", "sass-loader"],
      },
      {
        test: /\.(woff2?|ttf|eot|otf)$/,
        type: "asset/resource",
        generator: {
          filename: "fonts/[name][ext][query]"  // put fonts in dist/fonts/
        }
      },
    ],
  },
  plugins: [
    new RemoveEmptyScriptsPlugin(),
    new MiniCssExtractPlugin({
      filename: "[name].min.css",
      chunkFilename: "[name].min.css"
    }),
  ],
  optimization: {
    minimize: true,
    minimizer: [
      `...`,                       // Terser for JS
      new CssMinimizerPlugin(),    // Minify CSS
    ],
    // Pull any node_modules code into a single vendor chunk
    splitChunks: {
      chunks: "all",
      cacheGroups: {
        vendor_js: {
          test: /[\\/]node_modules[\\/].*\.js$/,
          name: "js/vendor",
          enforce: true,
          priority: 20,
        },
        // Optional: vendor CSS (e.g., Swiper styles imported in SCSS)
        vendor_css: {
          test: /[\\/]node_modules[\\/].*\.(s?css|css)$/,
          name: "css/vendor",
          enforce: true,
          priority: 10,
        },
      },
    },
    // Keep this false to avoid generating a separate runtime chunk you’d have to enqueue
    runtimeChunk: false,
  },
  resolve: {
    extensions: [".js", ".scss", ".css"],
    preferRelative: true,
  },
  devtool: false,
};
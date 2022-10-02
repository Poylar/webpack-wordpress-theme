function importAll(r) {
  return r.keys().map(r);
}

importAll(require.context("../images/", true, /\.(png|jpe?g|svg|mp4)$/));

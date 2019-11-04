var routes = {
    "hi": {
        "uri": "get\/{id}"
    },
    "patch": {
        "uri": "patch"
    },
    "multiparam": {
        "uri": "multi\/{id}\/param\/{id2}\/url\/{id}"
    }
};

const route = (routeName, params = []) => {
  var _route = routes[routeName];
  if (_route == null) {
    throw "Requested route doesn't exist";
  }

  var uri = _route.uri;

  if (params instanceof Array) {
    params.forEach(param => {
      uri = uri.replace(/{[\w]+}/, param);
    });
  } else if (params instanceof Object) {
    Object.keys(params).forEach(key => {
      uri = uri.replace(new RegExp("{" + key + "}", "g"), params[key]);
    });
  }

  if (uri.includes("}")) {
    throw "Missing parameters";
  }

  return "/" + uri;
};

export { route };

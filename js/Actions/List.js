function loadList(text) {
    function subList(t, i) {
        let rv = "";
        let rl = [];
        let v = [];
        while (i < t.length) {
            if (t[i] === '\'' || t[i] === '\"') {
                i++;
                if (rv === "") {
                    rv = " ";
                }
                continue;
            }
            if (t[i] === "[") {
                i++;
                if (rv === " ") {
                    rv = "";
                }
                [i, v] = subList(t, i);
                rl.push(v);
                continue;
            }
            if (t[i] === "]") {
                if (t[i + 1] === "]" || t[i + 1] === ",") {
                    if (rv !== "") {
                        rl.push(rv);
                        rv = " ";
                    }
                    i++;
                    return [i, rl];
                }
                i++;
                continue;
            }
            if (t[i] === ",") {
                if (rv !== "") {
                    rl.push(rv);
                }
                i++;
                rv = "";
                continue;
            }
            if (rv !== "" && (t[i + 1] === "," || t[i + 1] === "]")) {
                rv += t[i];
                rl.push(rv);
                i++;
                rv = "";
                if (t[i + 1] === "]") {
                    return [i, rl];
                }
            } else {
                if (rv === " ") {
                    rv = "";
                }
                rv += t[i];
                i++;
            }
        }
        return [i, rl];
    }

    let ret = subList(text + ",", 0)[1];
    if (ret.length !== 0 || ret) {
        ret = ret[0];
    } else {
        ret = [];
    }
    return ret;
}
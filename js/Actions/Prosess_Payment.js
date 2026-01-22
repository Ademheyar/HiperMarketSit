function Start_Processing() {
    console.log("Start_Processing >>");

    // Set up initial conditions
    const a = 1;
    var activeChartIndex = localStorage.getItem('activeChartIndex');
    var isactiveChartData = localStorage.getItem('ActiveChartData');

    if (a && isactiveChartData) {
        var activeChartData = JSON.parse(isactiveChartData);
        var iscartData = activeChartData[activeChartIndex];
        var list_items_copy = iscartData ? activeChartData[activeChartIndex] : [];

        const response = confirm("Do you want to continue?");
        if (!response) return;

        const date = new Date().toLocaleDateString();
        let payments_ = [];
        let payments_extra = [];
        let extra_payment_needs = [];
        let Seller_id = 0;
        let payment_item_required = 0;
        let payment_open_drower = 0;
        let payment_print_slip = 1;
        let payment_customer_required = 0;
        let payment_enable = 0;
        let payment_change_allowed = 0;
        let payment_mark_pad = 0;
        let pay_index = 0;
        
        let itemforslip = "";
        let item_tobechanged = [];
        let item = ""; 
        let new_items = [];
        let count_new_items = 0; 
        let price = 0;
        let pid = 0;
        let T_pid = 0;
        let def_pid = 0;
        let disc = 0;
        let T_disc = 0;
        let tax = 0;
        let T_tax = 0;
        let change = 0;
        let brcod = "";

        // Create a unique document code
        let doc_code = new Date().toISOString().slice(2, 7) + "-11";
        let b = 0;
        while (true) {
            let ex_doc = cursor.execute("SELECT * FROM doc_table WHERE doc_barcode=?", (doc_code + b)).fetchone();
            if (ex_doc) {
                b = Math.floor(Math.random() * 10000);
            } else {
                brcod = doc_code + b;
                break;
            }
        }

        let ex_docs_info = [];

        console.log("brcod: " + brcod);
        console.log("sold list_items_copy: " + JSON.stringify(list_items_copy));

        // Process each item in the cart
        list_items_copy.forEach((iv, index) => {
            console.log("self.ex_items: " + JSON.stringify(self.ex_items));
            console.log("iv[11]: " + iv[11]);
            console.log("len(iv): " + iv.length);

            if (iv.length >= 13 && iv[13] && self.ex_items.includes(iv[13])) {
                return;
            }

            count_new_items += 1;
            console.log(iv[1]);

            cursor.execute("SELECT * FROM product WHERE id=?", [iv[1]]);
            let it = cursor.fetchone();
            let itl = [iv[1], iv[2], iv[3], iv[4], iv[12], iv[5], iv[6], iv[7], iv[8], iv[9], iv[10]];

            price += parseFloat(iv[7]) * parseFloat(iv[8]);
            disc += parseFloat(iv[9]);
            tax += parseFloat(iv[10]);
            new_items.push(itl);
            console.log("adding " + iv[7] + " to item_tobechanged");
            item_tobechanged.push([iv[1], it[13].toString(), 0, iv[12].toString(), iv[2].toString(), iv[5].toString(), iv[6].toString(), iv[7].toString()]);
            list_items_copy.splice(index, 1);
        });

        let p = 0;

        console.log("\n\nsold items collect: " + JSON.stringify(new_items) + "\n\n");

        const payments = localStorage.getItem('Payment_Lists');
        const paymentList = payments ? JSON.parse(payments) : [];

        // Process payment list
        while (p < paymentList.length) {
            console.log("paymentList: " + JSON.stringify(paymentList));
            console.log("self.ex_pid_peyment: " + JSON.stringify(self.ex_pid_peyment));
            console.log("paymentList[p]: " + JSON.stringify(paymentList[p]));

            if (paymentList[p][1] === "" || (paymentList[p].length >= 8 && self.ex_pid_peyment.includes(paymentList[p][7]))) {
                p += 1;
                continue;
            }

            pay_index += 1;
            console.log("paymentList[p]: " + JSON.stringify(paymentList[p]));
            let rows = 0;

            for (let r of self.Shop_Payment_Tools) {
                if (r[0] === paymentList[p][1]) {
                    rows = r;
                    break;
                }
            }

            if (rows) {
                console.log("rows: " + JSON.stringify(rows));
                console.log("price-disc: " + (price - disc) + ": pid " + pid + ": def_pid " + def_pid);

                let c = parseFloat(paymentList[p][2]);
                console.log("c: " + c);

                if (rows[5] === 1) payment_enable += 1;
                if (rows[6] === 1 && payment_item_required === 0) payment_item_required = 1;
                if (rows[7] === 1 && payment_customer_required === 0) payment_customer_required = 1;
                if (rows[8] === 1 && payment_print_slip === 0) payment_print_slip = 1;
                if (rows[9] === 1 && payment_change_allowed === 0) payment_change_allowed = 1;
                if (rows[10] === 1 && payment_mark_pad === 0) payment_mark_pad = 1;
                if (rows[11] === 1 && payment_open_drower === 0) payment_open_drower = 1;

                if (!rows[6]) {
                    price += c;
                    def_pid += c;
                }

                if (price - disc === pid) {
                    payments_extra.push([pay_index.toString(), paymentList[p][1], paymentList[p][2], date, date, self.user['User_name'], rows[10].toString(), paymentList[p][3]]);
                } else {
                    if (pid + c > price - disc) {
                        let pr = Math.floor((price - disc) / item.price);
                        let pl = pr - pid;

                        if (c > pl) {
                            let e = c - pl;
                            payments_extra.push([pay_index.toString(), paymentList[p][1], e.toString(), date, date, self.user['User_name'], rows[10].toString(), paymentList[p][3]]);
                            c = pl;
                        } else {
                            c = pl;
                        }
                    }

                    if (rows[6]) {
                        console.log("pid+c");
                        T_pid += parseFloat(paymentList[p][2]);
                        pid += c;
                    }

                    payments_.push([pay_index.toString(), paymentList[p][1], c.toString(), date, date, self.user['User_name'], rows[11].toString(), paymentList[p][3]]);
                }

                paymentList.splice(p, 1);
            } else {
                p += 1;
            }
        }

        console.log("\n\npayments_ pid collect: " + JSON.stringify(payments_) + "\n\n");
        console.log("--payments_extra: " + JSON.stringify(payments_extra));
        console.log("count ex_items items: " + list_items_copy.length);

        // Handling existing documents and payments
        for (let ex_i of self.ex_items) {
            let ex_doc = cursor.execute("SELECT * FROM doc_table WHERE doc_barcode=?", [ex_i[13]]).fetchone();
            if (!ex_doc) {
                continue;
            }
            
            if (self.ex_pid_peyment.includes(ex_i[1])) {
                continue;
            }

            let ex_pid_items = cursor.execute("SELECT * FROM payment_table WHERE doc_barcode=? AND Product_id=?", [ex_doc[1], ex_i[1]]).fetchall();
            for (let ex_pid of ex_pid_items) {
                if (!self.ex_pid_peyment.includes(ex_pid[2])) {
                    payments_extra.push([pay_index.toString(), ex_pid[1], ex_pid[2], ex_pid[3], ex_pid[4], ex_pid[5], ex_pid[6], ex_pid[7]]);
                }
            }
        }

        console.log("extra payment collect: " + JSON.stringify(payments_extra) + "\n\n");

        // Finalizing the transaction and updating the database
        if (count_new_items > 0) {
            const doc_status = 1;
            const full_discount = disc.toFixed(2);
            const full_tax = tax.toFixed(2);
            const doc_date = new Date().toISOString().slice(0, 10);

            cursor.execute(
                "INSERT INTO doc_table (doc_barcode, User_id, Seller_id, price, discount, tax, date, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
                [brcod, self.user['User_id'], Seller_id, price.toFixed(2), full_discount, full_tax, doc_date, doc_status]
            );

            new_items.forEach((item) => {
                cursor.execute(
                    "INSERT INTO sold_items (Product_id, Product_name, Product_quantity, Product_price, Discount, Tax, Barcode, Doc_Barcode) VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
                    [item[0], item[1], item[3], item[4], item[9], item[10], item[11], brcod]
                );
            });

            payments_.forEach((payment) => {
                cursor.execute(
                    "INSERT INTO payment_table (Doc_Barcode, Payment_Tool, Amount, date, time, User_name, Change_Allowed, Customer_Name) VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
                    payment
                );
            });

            if (payments_extra.length > 0) {
                payments_extra.forEach((extra) => {
                    cursor.execute(
                        "INSERT INTO payment_table (Doc_Barcode, Payment_Tool, Amount, date, time, User_name, Change_Allowed, Customer_Name) VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
                        extra
                    );
                });
            }

            console.log("Transaction completed successfully!");
        }

        console.log("End of Start_Processing");
    }
}
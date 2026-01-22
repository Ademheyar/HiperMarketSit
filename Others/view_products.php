        a = Chacke_Security(self, self.user, 0)
        if a:
            print("user "+str(self.user))
            answer = tk.messagebox.askquestion("Question", "do you whant to continue?")
            if answer != 'yes':
                return
            # GET COPY OF ALL GIVEN INFO
            list_items_copy = self.Selected_items

            '''list_items_copy = ttk.Treeview(self.midel_frame, columns=("CODE", "BARCODE", "ITEM Name", "QTY", "PRICE", "DISCOUNT", "TAX", "TOTAL PRICE", "COLOR", "SIZE", "AT SHOP", "Extantion Barcode"))
            for a in self.list_items.get_children():
                items = self.list_items.item(a)
                list_items_copy.insert("", "end", text=items['text'], values= items['values'])'''

            
            date = datetime.datetime.now().strftime('%Y-%m-%d %H:%M:%S')
            payments_ = []
            
            payments_extra = []
            extra_payment_needs = []
            Seller_id = None
            payment_item_required = 0
            payment_open_drower = 0
            payment_print_slip = 1
            payment_customer_required = 0
            
            payment_enable = 0
            
            payment_change_allowed = 0
            payment_mark_pad = 0
            pay_index = 0
            #self.get_ex_doc_items(ex)
            #self.get_ex_doc_payments(ex)
            itemforslip = ""
            item_tobechanged = []
            item = "" # item found
            new_items = [] # item found
            count_new_items = 0 # itme counted
            price = 0 # new items price
            pid = 0   # for new items pid
            T_pid = 0 # for all pid 
            def_pid = 0# for cash with no item pid or credit
            disc = 0  # for new items disc
            T_disc = 0  # for total new items dics
            tax = 0  # tax
            T_tax = 0  # tax 
            change = 0
            
            brcod = ""

            # doc_code = "1"
            # Year:Month-docType 1 doccreateplatform 1 doc_numb
            #TODO make it create randim number so that ont to count
            doc_code = datetime.datetime.now().strftime('%y:%m') + "-11"
            b = 0
            while True:
                ex_doc = cursor.execute("SELECT * FROM doc_table WHERE doc_barcode=?", (doc_code+str(b),)).fetchone()
                if ex_doc:
                    b = random.randint(0, 10000)
                else:
                    brcod = doc_code+str(b)
                    break
            # ex_item = [each item [barcode, isitem, ispay, ex_item, ex_item_items, payments, ex_payment_count, ex_item_pric, ex_item_T_disc, ex_item_T_tax, ex_pid]
            ex_docs_info = []

            
            
            print("brcod :" + str(brcod))
            #print("count sold items :" + str(len(list_items_copy.get_children())))
            print("sold list_items_copy :" + str(list_items_copy))
            for iv in list_items_copy:
                print("self.ex_items :" + str(self.ex_items))
                print("iv[11] :" + str(iv[11]))
                print("len(iv) :" + str(len(iv)))
                if len(iv) >= 13 and str(iv[13]) != "" and str(iv[13]) in self.ex_items:
                    continue
                count_new_items += 1
                print(str(iv[1]))
                cursor.execute("SELECT * FROM product WHERE id=?", (iv[1],))
                it = cursor.fetchone()
                itl = [iv[1], iv[2], iv[3], iv[4], iv[12], iv[5], iv[6], iv[7], iv[8], iv[9], iv[10]]
                
                price += float(iv[7])*float(iv[8])
                disc += float(iv[9])
                tax += float(iv[10])
                new_items.append(itl)
                print("adding " + str(iv[7]) + " to item_tobechanged")
                item_tobechanged.append([iv[1], str(it[13]), 0, str(iv[12]), str(iv[2]), str(iv[5]),str(iv[6]), str(iv[7])])            
                list_items_copy.remove(iv)
            p = 0

            print("\n\n sold items collect :" + str(new_items)+"\n\n")
            
            while p < len(self.pid_peyment):
                print("self.pid_peyment:" + str(self.pid_peyment))
                print("self.ex_pid_peyment:" + str(self.ex_pid_peyment))
                print("self.pid_peyment[p]:" + str(self.pid_peyment[p]))
                if self.pid_peyment[p][1] == "" or len(self.pid_peyment[p]) >= 8 and self.pid_peyment[p][7] in self.ex_pid_peyment:
                    p += 1
                    continue
                pay_index += 1
                print("self.pid_peyment[p]:" + str(self.pid_peyment[p]))
                rows = 0
                for r in self.Shop_Payment_Tools:
                    if r[0] == self.pid_peyment[p][1]:
                        rows = r
                        break
                if rows:
                    print("rows:" + str(rows))
                    print("price-disc "+str(price-disc) + ":pid " + str(pid) + ":def_pid " + str(def_pid))
                    c = float(self.pid_peyment[p][2])
                    print("c:" + str(c))
                    if rows[5] == 1: # chack if enabled
                        payment_enable += 1
                    if rows[6] == 1 and payment_item_required == 0: # chack if enabled
                        payment_item_required = 1
                    if rows[7] == 1 and payment_customer_required == 0: # chack if enabled
                        payment_customer_required = 1
                    if rows[8] == 1 and payment_print_slip == 0: # chack if enabled
                        payment_print_slip = 1
                    if rows[9] == 1 and payment_change_allowed == 0: # chack if enabled
                        payment_change_allowed = 1
                    if rows[10] == 1 and payment_mark_pad == 0: # chack if enabled
                        payment_mark_pad = 1
                    if rows[11] == 1 and payment_open_drower == 0: # chack if enabled
                        payment_open_drower = 1
                    if not rows[6]:
                        price += c
                        def_pid += c
                        
                    if price-disc == pid:
                        payments_extra.append([str(pay_index), str(self.pid_peyment[p][1]), str(self.pid_peyment[p][2]), date, date, self.user['User_name'], str(rows[10]), str(self.pid_peyment[p][3])])
                    else:
                        if pid + c > price-disc:
                            pr = (price-disc) # item price
                            pl = pr-pid     # price left to pay
                            if c > pl:
                                e = c - pl
                                payments_extra.append([str(pay_index), str(self.pid_peyment[p][1]), str(e), date, date, self.user['User_name'], str(rows[10]), str(self.pid_peyment[p][3])])
                                c = pl # taking only what pied
                            else:
                                c = pl
                        if rows[6]:
                            print("pid+c ")
                            T_pid += float(self.pid_peyment[p][2])
                            pid += c
                        payments_.append([str(pay_index), str(self.pid_peyment[p][1]), str(c), date, date, self.user['User_name'], str(rows[11]), str(self.pid_peyment[p][3])])
                    self.pid_peyment.remove(self.pid_peyment[p])
                elif p+1 < len(self.pid_peyment):
                    p += 1
            
            print("\n\n payments_ pid collect :" + str(payments_)+"\n\n")
            
            print("--payments_extra : " + str(payments_extra))
            print("count ex_items items :" + str(len(list_items_copy)))
            for ex_i in self.ex_items:
                ex_doc = cursor.execute("SELECT * FROM doc_table WHERE doc_barcode=?", (ex_i,)).fetchone()
                if ex_doc:
                    ex_item_list = load_items(ex_doc[6])
                    ite = "" # item found
                    ex_items = [] # item found
                    ex_item_count = 0 # itme counted
                    ex_T_price = 0 # new items price
                    ex_T_pid = 0   # for new items pid
                    ex_T_disc = 0  # for total new items dics
                    ex_T_tax = 0  # tax 
                    print("ex_item_list : " + str(ex_item_list))
                    iti = 0
                    while(iti < len(ex_item_list)):
                        itf = 0 # IF IT VALUE TO DELET OR NOT
                        it = ex_item_list[iti]
                        print("ex_it : " + str(it))
                        ex_tax = 0  # tax
                        ex_disc = 0  # for new items disc
                        for iv in list_items_copy:
                            print("comparring id "+str(id)+" and it[0] " + str(it[0]))
                            if iv[11] == ex_i and id == it[0]:
                                print(str(id))
                                print("item is same " + str(list_items_copy.item(a)))
                                ex_item_count += 1
                                
                                
                                q = None
                                print("searching item in product "+str(id))

                                print("self.ex_items :" + str(self.ex_items))
                                print("iv[11] :" + str(iv[11]))
                                print("len(iv) :" + str(len(iv)))
                                if len(iv) >= 13 and str(iv[13]) != "" and str(iv[13]) in self.ex_items:
                                    continue
                                count_new_items += 1
                                print(str(iv[1]))
                                p_it = cursor.execute("SELECT * FROM product WHERE id=?", (id,)).fetchone()
                                
                                
                                if p_it:
                                    itl = [iv[1], iv[2], iv[3], iv[4], iv[12], iv[5], iv[6], iv[7], iv[8], iv[9], iv[10]]
                                    ex_items.append(itl)
                                    ex_T_disc += float(iv[9])
                                    ex_T_tax += float(iv[10])
                                    
                                    print("item info :" + str(iv))
                                    q = float(it[9]) - float(iv[7]) if float(it[9]) < float(iv[7]) else float(iv[7]) - float(it[9])
                                    
                                if q != 0 and q != None:
                                    print("2adding " + str(iv[7]) + " to item_tobechanged")
                                    print("len :" + str(q))
                                    item_tobechanged.append([iv[1], str(p_it[13]), 1, str(iv[12]), str(iv[2]), str(iv[5]),str(iv[6]), str(q)]) 
                                list_items_copy.remove(iv)
                                itf = 1 # remove founded item
                        if(itf == 1):
                            ex_item_list.remove(it)
                        else:
                            iti += 1
                    ex_docs_info.append([ex_i, 1, 0, ite, ex_item_count, "", 0, ex_T_price, ex_T_disc, ex_T_tax, 0])
                    # THIS WILL TALL TO REMOVE REDUSDE ITEMS FROM DOC IF NOT MANTIOND IN THE NEW ONE
                    if len(ex_item_list) > 0:
                        for it in ex_item_list:
                            print("left ex_it : " + str([it[1], it[3]]))
                            p_it = cursor.execute("SELECT * FROM product WHERE id=?", (it[0],)).fetchone()
                            if not p_it:
                                p_it = cursor.execute("SELECT * FROM product WHERE code LIKE ? AND name LIKE ?", ('%' + it[1] + '%', '%' + it[3] + '%')).fetchone()   
                                
                            print("p_it : " + str(p_it))
                            
                            print("3adding " + str(it[5]) + " to item_tobechanged")
                            item_tobechanged.append([p_it[0], str(p_it[12]), 1, str(it[4]), str(it[1]), str(it[5]),str(it[6]), str(it[7])])
                            ex_item_list.remove(it)
                print("--ex_item_list : " + str(ex_item_list))

            print("\n\n ex_docs_info item collect :" + str(ex_docs_info)+"\n\n")
            
            # todo what if the ex doc is orady payed in ex doc work on chane ex doc
            for ex_p in self.ex_pid_peyment:
                ex_doc = cursor.execute("SELECT * FROM doc_table WHERE doc_barcode=?", (ex_p,)).fetchone()
                if ex_doc:
                    ex_item_list = load_payment(ex_doc[11])
                    ex_pay_t = ""
                    ex_pay_count = 0
                    ex_pid = 0
                    fou = -1
                    e = 0
                    for ex_d_info in ex_docs_info:
                        if ex_d_info[0] == ex_p:
                            fou = e
                            break
                        e += 1
                    if fou == -1:
                        #todo get in doc value its price, disc, tax to append in next list
                        ex_docs_info.append([ex_p, 0, 0, "", 0, "", "", 0, 0, 0, 0])
                        fou = len(ex_docs_info)-1
                        
                    for it in ex_item_list:
                        for p in self.pid_peyment:
                            print("p[] "+str(p) + ":" + str(ex_p))
                            if p[7] == ex_p:
                                print("self.extra_pid_peyment[p]:" + str(it))
                                if p[1] == "":
                                    self.pid_peyment.remove(p)
                                    continue
                                pay_index += 1
                                if ex_pay_t != "":
                                    ex_pay_t += ","
                                rows = cursor.execute("SELECT * FROM tools WHERE name=?", (p[0],)).fetchall()
                                ispid = 1
                                if rows:
                                    ispid = rows[0][11]
                                c = float(p[2])
                                print("\n\nc "+str(c))
                                print("ex_pid "+str(ex_pid))
                                print("ex_docs_info[fou][7] "+str(ex_docs_info[fou][7]))
                                print("ex_docs_info[fou][8] "+str(ex_docs_info[fou][8]))
                                print("\n\n")
                                ex_pay_count += 1
                                # todo chacke if updated date is deffernt
                                ex_pay_t += "(" + str(it[0]) + "," + str(p[1]) + "," +  str(p[2]) + "," + it[3] + "," + date + "," + it[5] + "," + str(ispid) + "," + p[7] + ")"
                                if ex_pid + c <= float(ex_docs_info[fou][7])-float(ex_docs_info[fou][8]):
                                    ex_pid += c
                                else:
                                    colect = 0
                                    if ex_pid + c > float(ex_docs_info[fou][7])-float(ex_docs_info[fou][8]):
                                        ex_pay_count += 1
                                        pr = (float(ex_docs_info[fou][7])-float(ex_docs_info[fou][8]))-ex_pid # get remaning price unpid one
                                        c = c-pr # didact extra pid amount the remaing aount
                                        ex_pid += pr # update pid with filling remaing amount
                                        # save it
                                        #ex_pay_t += "(" + str(it[0]) + "," + str(p[1]) + "," +  str(c) + "," + it[3] + "," + date + "," + it[5] + "," + str(ispid) + "," + p[7] + ")"                                    
                                        if pid != 0 and price-disc != pid: # cacke if new item have remaning unpid amunt
                                            if price-disc-pid >= c:
                                                c=c
                                            if price-disc-pid < c:
                                                colect = c-price-disc
                                                c = price-disc-colect
                                            pid += c
                                            payments_ += "(" + str(it[0]) + "," + str(p[1]) + "," + str(c) + "," + it[3] + "," + date + "," + it[5] + "," + str(ispid) + "," + p[7] + ")"
                                            ex_pay_t += ",("+ str(it[0]) + ","+str(brcod)+",-" +  str(c) + "," + it[3] + "," + date + "," + it[5] + "," + str(ispid) + "," + p[7] + ")"
                                          
                                    if price-disc == pid or colect > 0:
                                        for e_p_n in extra_payment_needs:
                                            for ex_d_info in ex_docs_info:
                                                if ex_d_info[0] == e_p_n:
                                                    if float(ex_d_info[7])-float(ex_d_info[8])-float(ex_d_info[10]) >= c:
                                                        c=c
                                                    if float(ex_d_info[7])-float(ex_d_info[8])-float(ex_d_info[10]) < c:
                                                        colect = c-float(ex_d_info[7])-float(ex_d_info[8])
                                                        c = float(ex_d_info[7])-float(ex_d_info[8])-colect
                                                    
                                                    ept = "(" + str(it[0]) + "," + str(p[1]) + "," + str(c) + "," + it[3] + "," + date + "," + it[5] + "," + str(ispid) + "," + p[7] + ")"
                                                    print("ept "+str(ept))
                                                    ex_d_info[2] = 1
                                                    co = ""
                                                    if ex_d_info[5] != "":
                                                        co = ","
                                                    ex_d_info[5] = str(ex_d_info[5]) + co + ept
                                                    ex_d_info[6] = float(ex_d_info[6]) + 1
                                                    ex_d_info[10] = str(float(ex_d_info[10]) + float(c))
                                                    break
                                    if colect > 0: # else put extra payment for othere use
                                        payments_extra.append([str(it[0]), str(p[1]), str(exp), it[3], date, it[5], str(ispid), p[7]])
                                        
                            self.pid_peyment.remove(p)
                    left = (float(ex_docs_info[fou][7])-float(ex_docs_info[fou][8])) - ex_pid
                    print("[[fou][7], [fou][8], ex_pid " + str([float(ex_docs_info[fou][7]), float(ex_docs_info[fou][8]), ex_pid]) + " left "+str(left))
                    print("payments_extra :: " + str(payments_extra))
                    if left != 0:
                        # TODO IF PAID IS LESS AND THERE IS NO EXTRA PAIMENT RETURN ERROR SHORT PAYMENT
                        L = []
                        colect = 0
                        for ex_pa in payments_extra:
                            p = float(ex_pa[2])
                            colect += p
                            ex_bc = ex_pa[7]
                            if ex_bc == '':
                                ex_bc = ex_p
                            if colect > left:
                                q = colect-left
                                ex_pa[2] = q
                                p = colect - q
                            elif colect < left:
                                L.append("(" + str(ex_pa[0]) + "," + str(ex_pa[1]) + "," +  str(p) + "," + ex_pa[3] + "," + ex_pa[4] + "," + ex_pa[5] + "," + str(ex_pa[6]) + "," + ex_bc + ")")
                                ex_pa = []
                                continue
                            if colect == left:
                                L.append("(" + str(ex_pa[0]) + "," + str(ex_pa[1]) + "," +  str(p) + "," + ex_pa[3] + "," + ex_pa[4] + "," + ex_pa[5] + "," + str(ex_pa[6]) + "," + ex_bc + ")")
                                for inl in L:
                                    if ex_pay_t != "":
                                        ex_pay_t += ","
                                    ex_pay_t += inl
                            if ex_pa[7] == "":
                                T_pid -= float(ex_pa[2])
                            payments_extra.remove(ex_pa)
                            
                    if ex_pay_t != "":
                        if fou != -1:
                            print("ex_pay_t "+str(ex_pay_t))
                            ex_docs_info[fou][2] = 1
                            co = ""
                            if ex_docs_info[fou][5] != "":
                                co = ","
                            ex_docs_info[fou][5] = str(ex_docs_info[fou][5]) + co + ex_pay_t
                            ex_docs_info[fou][6] = float(ex_docs_info[fou][6]) + ex_pay_count
                            ex_docs_info[fou][10] = str(float(ex_docs_info[fou][10]) + ex_pid)



            print("\n\n sold items collect :" + str(new_items)+"\n\n")
            print("\n\n payments_ pid collect :" + str(payments_)+"\n\n")
            print("\n\n ex_docs_info item collect :" + str(ex_docs_info)+"\n\n")
            print("\n\n ex_docs_info payment collect :" + str(ex_docs_info)+"\n\n")
            
            print("--payments_extra : " + str(payments_extra))


            print("price-disc "+str(price-disc) + ":pid " + str(pid) + ":def_pid " + str(def_pid))

            f_user_s = cursor.execute("SELECT * FROM setting WHERE User_id=?", (int(self.user['User_id']),)).fetchall()
            print("f_user_s "+str(f_user_s))
            Seller_id = None

            if f_user_s and f_user_s[0] and f_user_s[0][5]:
                print("opning worker dialog")
                app = WorkerManagementApp(self, str(brcod), float(count_new_items))
                if app.user_details:
                    print("app.user_details['User_id'] "+str(app.user_details['User_id']))
                    Seller_id = app.user_details['User_id']
                else:
                    return
                
            if not def_pid == 0 and price-disc != pid and price-disc == pid + def_pid:
                pid += def_pid
            if pid == 0 and item != "":
                for e_doc_info in ex_docs_info:
                    if float(ex_d_info[7])-float(ex_d_info[8]) < float(ex_d_info[10]) and float(ex_d_info[10])-float(ex_d_info[7])-float(ex_d_info[8]) == price-disc:
                        if not e_doc_info[1]:
                            e_doc_info[1] = 1
                            e_doc_info[3] = ""
                        elif e_doc_info[3] != "":
                            e_doc_info[3] += ","
                        e_doc_info[3] += item
                        item = ""
                    elif e_doc_info[1] and e_doc_info[3] == "":
                        e_doc_info[3] = item
                        item = ""
            print("--item = " + str(item))
            print("--payments_ : " + str(payments_))
            print("pyment "+str(price) + ":" + str(pid))
            print("--item_tobechanged : " + str(item_tobechanged))
            
            print("--ex_docs_info : " + str(ex_docs_info))
            name = ""
            phone_num = ""
            cm_id = None
            old_cm_id = None
                            
            slip_doc_code = []
            '''while True:
                continue'''
            for change_item in item_tobechanged:
                print("item : " + str(change_item[1]), change_item[2], str(change_item[3]), str(change_item[4]),str(change_item[5]), str(change_item[6]))
                print("item info befor : " + str(change_item[1]))
                qty_info_list = []
                print("change_item[1]  : " + str(change_item[1]))
                if "\"{" in str(change_item[1]):
                    cod = str(change_item[4]).replace(",", "|")
                    qty_info_list = read_code(change_item[1], "", cod, "", "")[4]
                else:
                    qty_info_list = load_list(change_item[1])
                it_info = change_qty(qty_info_list, change_item[2], str(change_item[3]), str(change_item[4]), str(change_item[5]),str(change_item[6]), str(change_item[7]))

                print("item info befor  : " + str(it_info))
                #while True:
                #    continue
                cursor.execute('UPDATE product SET more_info=? WHERE id=?', (it_info, change_item[0]))
                        
                cursor.execute("SELECT * FROM product WHERE id=?", (change_item[0],))
                it2 = cursor.fetchone()
                        
                print("item info updated : " + str(it2[12]))
                
                # Commit the changes to the database
                conn.commit()
            if payment_customer_required:
                app = UserManagementApp(self, old_cm_id)
                if app.user_details:
                    self.custemr = app.user_details['User_id']
                    cm_id = self.custemr
                name = app.user_details['User_name']
                phone_num = app.user_details['User_phone_num']
                print(app.user_details)
                
            for e_doc_info in ex_docs_info:
                ppp0 = 0
                ppp = e_doc_info[5] 
                for exp in payments_extra:
                    if exp[7] == e_doc_info[0]:
                        if exp[1] != '':
                            if ppp != "":
                                ppp += ","
                            ppp += "(" + "," + ",-" +  str(exp[2]) + "," + str(exp[3]) + "," + date + "," + str(exp[5]) + "," + str(exp[6]) + "," + str(exp[7]) + ")"
                            ppp0 = 1
                            payment_open_drower = 1
                
                rows = cursor.execute("SELECT * FROM doc_table WHERE doc_barcode=?", (e_doc_info[0],)).fetchall()
                if rows and rows[0][4]:
                    old_cm_id = rows[0][4]
                
                print("cmd old id = " + str(rows[0]) + " new id " + str(cm_id))
                if cm_id and old_cm_id != str(cm_id):
                    #[each item [barcode, isitem, ispay, ex_item, ex_item_items, payments, ex_payment_count, ex_item_pric, ex_item_T_disc, ex_item_T_tax, ex_pid]
                    cursor.execute('UPDATE doc_table SET customer_id=? WHERE doc_barcode=?', (cm_id, e_doc_info[0]))
                    # Commit the changes to the database
                    conn.commit()
                if Seller_id != None:
                    #[each item [barcode, isitem, ispay, ex_item, ex_item_items, payments, ex_payment_count, ex_item_pric, ex_item_T_disc, ex_item_T_tax, ex_pid]
                    cursor.execute('UPDATE doc_table SET Seller_id=? WHERE doc_barcode=?', (Seller_id, e_doc_info[0]))
                    # Commit the changes to the database
                    conn.commit()
                if e_doc_info[1]:
                    #[each item [barcode, isitem, ispay, ex_item, ex_item_items, payments, ex_payment_count, ex_item_pric, ex_item_T_disc, ex_item_T_tax, ex_pid]
                    cursor.execute('UPDATE doc_table SET item=?, qty=?, price=?, discount=?, tax=?, doc_updated_date=? WHERE doc_barcode=?', (e_doc_info[3], e_doc_info[4], e_doc_info[7], e_doc_info[8], e_doc_info[9], date, e_doc_info[0]))
                    # Commit the changes to the database
                    conn.commit()
                if e_doc_info[2] or ppp0:
                    #todo if needed add pid in doc e_doc_info[10]
                    cursor.execute('UPDATE doc_table SET payments=?, doc_updated_date=? WHERE doc_barcode=?', (ppp, date, e_doc_info[0]))
                    # Commit the changes to the database
                    conn.commit()
                slip_doc_code.append(e_doc_info[0])
            
            if payments_ != "" and price-disc == pid:
                print("custemer : " + str(self.custemr) + "isneded : " + str(payment_customer_required))
                # TODO: chacke if self.At_Shop_Id is selected if not make user selecte one
                        
                cursor.execute('INSERT INTO upload_doc (doc_barcode, extension_barcode, At_Shop_Id, user_id, customer_id, Seller_id, type, item, qty, price, discount, tax, payments, pid, doc_created_date, doc_expire_date, doc_updated_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', (str(brcod), "extension_barcode", self.At_Shop_id, self.user['User_id'], self.custemr, Seller_id, "Sale_item", json.dumps(new_items), float(count_new_items), price, disc, tax, json.dumps(payments_), T_pid, date, "doc_expire_date", date))
                cursor.execute('INSERT INTO doc_table (doc_barcode, extension_barcode, At_Shop_Id, user_id, customer_id, Seller_id, type, item, qty, price, discount, tax, payments, pid, doc_created_date, doc_expire_date, doc_updated_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', (str(brcod), "extension_barcode", self.At_Shop_id, self.user['User_id'], self.custemr, Seller_id, "Sale_item", json.dumps(new_items), float(count_new_items), price, disc, tax, json.dumps(payments_), T_pid, date, "doc_expire_date", date))
                # Commit the changes to the database
                conn.commit()
                slip_doc_code.append(brcod)
             
            # call void         
            #self.void_items()
            
            if payment_open_drower == 1:
                PrinterForm.open_drower(self, self.user)
             
            ApproveFrame(self, self.user, slip_doc_code, payments_extra, payment_print_slip)

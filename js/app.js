var ABI = [{"constant":true,"inputs":[],"name":"name","outputs":[{"name":"","type":"string"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_spender","type":"address"},{"name":"_value","type":"uint256"}],"name":"approve","outputs":[{"name":"success","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"totalSupply","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_from","type":"address"},{"name":"_to","type":"address"},{"name":"_value","type":"uint256"}],"name":"transferFrom","outputs":[{"name":"success","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"name":"","type":"uint256"}],"name":"minterList","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_address","type":"address"}],"name":"removeMinter","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"decimals","outputs":[{"name":"","type":"uint8"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"initialSupply","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[],"name":"stopWhiteCoinTrading","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"name":"","type":"address"}],"name":"minter","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_value","type":"uint256"}],"name":"burn","outputs":[{"name":"success","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"_amount","type":"uint256"},{"name":"_ref","type":"string"}],"name":"mintingRequest","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"name":"","type":"uint256"}],"name":"mintRequestReference","outputs":[{"name":"","type":"string"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"standard","outputs":[{"name":"","type":"string"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"tokenHolder","type":"address"}],"name":"balanceOf","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_address","type":"address"}],"name":"unfreezeAccount","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"_from","type":"address"},{"name":"_value","type":"uint256"}],"name":"burnFrom","outputs":[{"name":"success","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"_mintRequest","type":"uint256"},{"name":"_decision","type":"uint8"}],"name":"mintWhitecoin","outputs":[{"name":"success","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"symbol","outputs":[{"name":"","type":"string"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_address","type":"address"}],"name":"addMinter","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"minterCount","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"","type":"uint256"}],"name":"mintRequest","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_to","type":"address"},{"name":"_value","type":"uint256"}],"name":"transfer","outputs":[{"name":"ok","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"_address","type":"address"}],"name":"isMinter","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"name":"","type":"address"}],"name":"frozenAccount","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"","type":"uint256"}],"name":"mintRequestStatus","outputs":[{"name":"","type":"uint8"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_to","type":"address"},{"name":"_value","type":"uint256"},{"name":"_data","type":"bytes"}],"name":"transfer","outputs":[{"name":"ok","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"name":"","type":"uint256"}],"name":"mintRequestor","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_spender","type":"address"},{"name":"_value","type":"uint256"},{"name":"_extraData","type":"bytes"}],"name":"approveAndCall","outputs":[{"name":"success","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"mintRequestCount","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"","type":"address"}],"name":"manager","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"WhiteCoinActive","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[],"name":"startWhitecoinTrading","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"name":"","type":"uint256"}],"name":"managerList","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"_owner","type":"address"},{"name":"_spender","type":"address"}],"name":"allowance","outputs":[{"name":"remaining","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_to","type":"address"},{"name":"_value","type":"uint256"},{"name":"_data","type":"bytes"},{"name":"_stringdata","type":"string"},{"name":"_numdata","type":"uint256"}],"name":"transfer","outputs":[{"name":"ok","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"_address","type":"address"}],"name":"freezeAccount","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"_address","type":"address"}],"name":"isManager","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"inputs":[],"payable":false,"stateMutability":"nonpayable","type":"constructor"},{"anonymous":false,"inputs":[{"indexed":true,"name":"from","type":"address"},{"indexed":true,"name":"to","type":"address"},{"indexed":false,"name":"value","type":"uint256"}],"name":"Transfer","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"name":"from","type":"address"},{"indexed":true,"name":"to","type":"address"},{"indexed":false,"name":"value","type":"uint256"},{"indexed":false,"name":"data","type":"bytes"}],"name":"Transfer","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"name":"from","type":"address"},{"indexed":true,"name":"to","type":"address"},{"indexed":false,"name":"value","type":"uint256"},{"indexed":false,"name":"data","type":"bytes"},{"indexed":false,"name":"_stringdata","type":"string"},{"indexed":false,"name":"_numdata","type":"uint256"}],"name":"Transfer","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"name":"owner","type":"address"},{"indexed":true,"name":"spender","type":"address"},{"indexed":false,"name":"value","type":"uint256"}],"name":"Approval","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"name":"amount","type":"uint256"},{"indexed":true,"name":"id","type":"uint256"}],"name":"NewMintingRequest","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"name":"from","type":"address"},{"indexed":false,"name":"value","type":"uint256"}],"name":"Burn","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"name":"from","type":"address"},{"indexed":false,"name":"value","type":"uint256"}],"name":"Minted","type":"event"}];

var WhiteContract;
var WhiteCoin;
var contractAddress = 0;
var wcursum = 0;
var isMinter = false;

window.App = {

    convertSendAmount(amount) {
        return amount * 1000000000000000000;
        // return amount;
    },

    // Баланс пользователя в эфирах
    getEtherBalance: function() {
        web3.eth.getBalance(web3.eth.defaultAccount, (error, result) => {
            // TODO: Добавить обработку результата
            // console.log(result)
            contractAddress = web3.eth.defaultAccount;
            for(var i=0;i<document.getElementsByClassName('ethereum').length;i++) {
                document.getElementsByClassName('ethereum')[i].innerHTML = (parseInt(result)/1000000000000000000).toFixed(8);
            }
            for(var i=0;i<document.getElementsByClassName('ethereum2').length;i++) {
                document.getElementsByClassName('ethereum2')[i].innerHTML = web3.eth.defaultAccount;
            }
        })
    },

    // Инициализирует скрипт
    init: function () {
        WhiteContract = web3.eth.contract(ABI);
        WhiteCoin = WhiteContract.at('0x838C133dA3C493D728d49FA94f4f9B1930651e2a');
        // 0x637AAc4a0f5268377c14979baaBb746BcC6eA4BF
        // 0xCAA3FbCC5eC1B61dD2762A6B905A3a400c9b199C
        // 0x85c015a9e36eb50c574b3b6a049be05c62f0e938
    },

    // Возвращает баланс пользователя
    getBalance: function () {
        WhiteCoin.balanceOf(web3.eth.defaultAccount, (error, result) => {
            // TODO: Добавить сюда обработку результата
            // console.log(JSON.stringify(web3.eth.accounts))
            if(result) {
                $.ajax({
                    type: 'post',
                    data: 'amnt='+web3.eth.defaultAccount+'&act=setethwallet',
                    url: '/coms/mktransaction.php',
                    success: function(suc) {
                        console.log(JSON.stringify(suc));
                    },
                    error: function(err) {
                        alert('An unknown error occurred!')
                        console.log(JSON.stringify(err));
                        $('.sendreqEth').show();
                    }
                });
            }
            for(var i=0;i<document.getElementsByClassName('wcunrestricted').length;i++) {
                document.getElementsByClassName('wcunrestricted')[i].innerHTML = result;
                wcursum = result;
            }
            for(var i=0;i<document.getElementsByClassName('wcunrestricted2').length;i++) {
                document.getElementsByClassName('wcunrestricted2')[i].innerHTML = web3.eth.defaultAccount;
            }
        })
    },

    // Возвращает общее количество токенов
    getTotalSupply: function () {
        WhiteCoin.totalSupply((error, result) => {
            // TODO: Добавить сюда обработку результата
            for(var i=0;i<document.getElementsByClassName('unrestrictedwallet').length;i++) {
                document.getElementsByClassName('unrestrictedwallet')[i].innerHTML = 'Unrestricted balance: '+result;
            }
        })
    },

    // Возвращает является ли пользователь эмитентом
    isMinter: function () {
        WhiteCoin.isMinter(web3.eth.defaultAccount, (error, result) => {
            // TODO: Добавить сюда обработку результата
            console.log('IS MINTER? '+result);
            if(result) {
                isMinter = true;
            }
            // return result;
        })
    },

    // Возвращает является ли пользователь эмитентом
    isMinterSend: function (val1, val2, val3, val4) {
        WhiteCoin.isMinter(web3.eth.defaultAccount, (error, result) => {
            // TODO: Добавить сюда обработку результата
            console.log('MINTER SEND: '+result);
            
            if(result) {
                if(confirm("Allow this transaction "+val1)) {
                    ajaxSend2(val1, val2, val3, val4);
                }
            }
            else {
                if(contractAddress) {
                    if(contractAddress != '0') {
                        WhiteCoin.addMinterSend(contractAddress, val1, val2, val3, val4);
                    }
                    else {
                        new PNotify({
                            title: "White Standard + Metamask",
                            type: "error",
                            text: "Be sure you had logged in with Metamask!",
                            nonblock: {
                                nonblock: true
                            },
                            before_close: function(PNotify) {
                                // You can access the notice's options with this. It is read only.
                                //PNotify.options.text;
                
                                // You can change the notice's options after the timer like this:
                                PNotify.update({
                                title: PNotify.options.title + " - Enjoy your Stay",
                                before_close: null
                                });
                                PNotify.queueRemove();
                                return false;
                            }
                        });
                    }
                }
                else {
                    new PNotify({
                        title: "White Standard + Metamask",
                        type: "error",
                        text: "Be sure you had logged in with Metamask.",
                        nonblock: {
                            nonblock: true
                        },
                        before_close: function(PNotify) {
                            // You can access the notice's options with this. It is read only.
                            //PNotify.options.text;
                
                            // You can change the notice's options after the timer like this:
                            PNotify.update({
                                title: PNotify.options.title + " - Enjoy your Stay",
                                before_close: null
                            });
                            PNotify.queueRemove();
                            return false;
                        }
                    });
                }
            }
                
            // return result;
        })
    },

    // Добавляет эмитента
    addMinter: function (val1, address) {
        WhiteCoin.addMinter(address, (error, result) => {
            // TODO: Добавить сюда обработку результата
            console.log('ADD MINTER '+result);
            // return result;
            if(result) {
				$.ajax({
					type: 'post',
					data: 'amnt=1&act=minterrest&adr='+address+'&fromadr='+val1,
					url: '/coms/mktransaction.php',
					success: function(suc) {
						$('#usersTable').DataTable().ajax.reload();
						// console.log(JSON.stringify(suc));
					},
					error: function(err) {
						alert('An unknown error occurred!')
						console.log(JSON.stringify(err));
					}
				});
            }
        })
    },

    // Добавляет эмитента
    addMinterSend: function (address, val1, val2, val3, val4) {
        WhiteCoin.addMinter(address, (error, result) => {
            // TODO: Добавить сюда обработку результата
            console.log('IS MINTER: '+result);
            // return result;
            if(result) {
                if(confirm("Allow this transaction "+val1)) {
                    ajaxSend2(val1, val2, val3, val4);
                }
            }
        })
    },

    // Удаляет эмитента
    removeMinter: function (address) {
        WhiteCoin.removeMinter(address, (error, result) => {
            // TODO: Добавить сюда обработку результата
            console.log('REMOVE MINTeR '+result);
            $.ajax({
                type: 'post',
                data: 'amnt=0&act=minterrest&adr='+address+'&fromadr='+val1,
                url: '/coms/mktransaction.php',
                success: function(suc) {
                    $('#usersTable').DataTable().ajax.reload();
                    // console.log(JSON.stringify(suc));
                },
                error: function(err) {
                    alert('An unknown error occurred!')
                    console.log(JSON.stringify(err));
                }
            });
        })
    },

    // Удаляет эмитента
    removeMinterRest: function (val1, address) {
        WhiteCoin.removeMinter(address, (error, result) => {
            // TODO: Добавить сюда обработку результата
            // console.log(result);
            // return result;
            if(result) {
				$.ajax({
					type: 'post',
					data: 'amnt=0&act=minterrest&adr='+address+'&fromadr='+val1,
					url: '/coms/mktransaction.php',
					success: function(suc) {
						$('#usersTable').DataTable().ajax.reload();
						// console.log(JSON.stringify(suc));
					},
					error: function(err) {
						alert('An unknown error occurred!')
						console.log(JSON.stringify(err));
					}
				});
            }
        })
    },

    // Удаляет эмитента
    removeMinterDel: function (val1, address) {
        WhiteCoin.removeMinter(address, (error, result) => {
            // TODO: Добавить сюда обработку результата
            // console.log(result);
            // return result;
            if(result) {
                var datastr = 'act=mintdel&adr='+val1+'&amnt='+address;
                $.ajax({
                  type: 'post',
                  url: '/coms/mktransaction.php',
                  data: datastr,
                  success: function(suc) {
                      console.log(JSON.stringify(suc));
                      var suc = JSON.parse(suc);
                      if(suc.success == 0) {
                        new PNotify({
                            title: "Error!",
                            type: "error",
                            text: "No such Minter.",
                            nonblock: {
                                nonblock: true
                            },
                            before_close: function(PNotify) {
                                // You can access the notice's options with this. It is read only.
                                //PNotify.options.text;
        
                                // You can change the notice's options after the timer like this:
                                PNotify.update({
                                    title: PNotify.options.title + " - Enjoy your Stay",
                                    before_close: null
                                });
                                PNotify.queueRemove();
                                return false;
                            }
                        });
                      }
                      else if(suc.success == 1) {
                        $('#usersTable').DataTable().ajax.reload();
                      }
                  },
                  error: function(err) {
                    alert('Some error occured!')
                  }
                })
            }
        })
    },

    // Отправляет токены
    transfer: function (to, value) {
        WhiteCoin.transfer(to, this.convertSendAmount(value), (error, result) => {
            // TODO: Добавить сюда обработку результата
            console.log('TRANSFER: '+result);
            return result;
        })
    },

    // Отправляет токены
    transferTrans: function (to, value, id) {
        WhiteCoin.transfer(to, this.convertSendAmount(value), (error, result) => {
            // TODO: Добавить сюда обработку результата
            console.log('TRANSFER: '+result);
            // return result;
            if(result) {
                var datastr = 'act=adminproof&adr='+id+'&amnt='+value;
                $.ajax({
                    type: 'post',
                    url: '/coms/mktransaction.php',
                    data: datastr,
                    success: function(suc) {
                        // console.log(JSON.stringify(suc));
                        $('#transTable').DataTable().ajax.reload();
                    },
                    error: function(err) {
                        alert('Some error occured!')
                    }
                })
            }
        })
    },

    // Отправляет токены
    transferReqWCUR: function (to, value) {
        WhiteCoin.transfer(to, this.convertSendAmount(value), (error, result) => {
            // TODO: Добавить сюда обработку результата
            // console.log(result);
            // return result;
            if(result) {
                $('.sendreqEth').hide();
                $.ajax({
                    type: 'post',
                    data: 'amnt='+$('#moneysellEth').val()+'&act=reqwcur',
                    url: '/coms/mktransaction.php',
                    success: function(suc) {
                        var succ = JSON.parse(suc);
                        // console.log(JSON.stringify(suc)+' | '+suc.success+' | '+suc[0].success+' | '+succ.success);
                        if(succ.success == 1) {
                            $('.sentrequestEth').html('<h2 style="padding:6px 12px;">Request for White Standard sent!</h2>');
                        }
                        else {
                            $('.sentrequestEth').html('<h2 style="padding:6px 12px;color:#f00;">An error occured!</h2>');
                        }
                    },
                    error: function(err) {
                        alert('An unknown error occurred!')
                        console.log(JSON.stringify(err));
                        $('.sendreqEth').show();
                    }
                });
            }
        })
    },

    // Забирает токены
    transferRedeemWCUR: function (to, value) {
        WhiteCoin.transfer(to, this.convertSendAmount(value), (error, result) => {
            // TODO: Добавить сюда обработку результата
            // console.log(result);
            // return result;
            if(result) {
                $('.sendredeemEth').hide();
                $.ajax({
                  type: 'post',
                  data: 'amnt='+$('#wcsellEth').val()+'&act=sellwcur',
                  url: '/coms/mktransaction.php',
                  success: function(suc) {
                    var succ = JSON.parse(suc);
                    // console.log(JSON.stringify(suc)+' | '+suc.success+' | '+suc[0].success+' | '+succ.success);
                    if(succ.success == 1) {
                      $('.sentredeemEth').html('<h2 style="padding:6px 12px;">Request for Ether sent!</h2>');
                    }
                    else {
                      $('.sentredeemEth').html('<h2 style="padding:6px 12px;color:#f00;">An error occured!</h2>');
                    }
                  },
                  error: function(err) {
                    alert('An unknown error occurred!')
                    console.log(JSON.stringify(err));
                    $('.sendredeemEth').show();
                  }
                });
            }
        })
    },

    // Отправляет токены от юзера к юзеру
    transferPrivate: function (to, value) {
        WhiteCoin.transfer(to, this.convertSendAmount(value), (error, result) => {
            // TODO: Добавить сюда обработку результата
            // console.log(result);
            // return result;
            if(result) {
                var notesenc = encodeURIComponent($('textarea#sendNotes').val());
                var sendstr = 'amnt='+$('input#sendAmount').val()+'&adr='+$('input#walletRec').val()+'&notes='+notesenc+'&fromadr='+$('select#walletSend').val()+'&act=sendwcur';
                $.ajax({
                    type: 'post',
                    data: sendstr,
                    url: '/coms/mktransaction.php',
                    success: function(suc) {
                        var succ = JSON.parse(suc);
                        console.log(JSON.stringify(suc));
                        if(succ.success == 1) {
                            new PNotify({
                                title: "Success!",
                                type: "success",
                                text: "Transaction gone.",
                                nonblock: {
                                nonblock: true
                                },
                                before_close: function(PNotify) {
                                // You can access the notice's options with this. It is read only.
                                //PNotify.options.text;

                                // You can change the notice's options after the timer like this:
                                PNotify.update({
                                    title: PNotify.options.title + " - Enjoy your Stay",
                                    before_close: null
                                });
                                PNotify.queueRemove();
                                return false;
                                }
                            });
                            elmErr = elmForm.children('.has-error');
                            $('button.sw-btn-next').hide();
                            $('button.sw-btn-prev').hide();
                            setTimeout(function() {
                                $('#smartwizard').smartWizard("reset");
                                $('#myForm').find("input, textarea").val("");
                                $('#myForm').find("select").val("WCR");
                                $('#fromWalletConf').html("");
                                $('#toWalletConf').html("");
                                $('#sendSumConf').html("");
                                $('#commsConf').html("");
                                $('#amountRecConf').html("");
                                $('#notesConf').html("");
                            }, 2000);
                        }
                        else if(succ.success == 0) {
                            new PNotify({
                                title: "Not enough money!",
                                type: "error",
                                text: "Not enough money in your wallet.",
                                nonblock: {
                                nonblock: true
                                },
                                before_close: function(PNotify) {
                                // You can access the notice's options with this. It is read only.
                                //PNotify.options.text;

                                // You can change the notice's options after the timer like this:
                                PNotify.update({
                                    title: PNotify.options.title + " - Enjoy your Stay",
                                    before_close: null
                                });
                                PNotify.queueRemove();
                                return false;
                                }
                            });
                        }
                        else if(succ.success == 2) {
                            new PNotify({
                                title: "No receiver!",
                                type: "error",
                                text: "There is no receiver with this wallet.",
                                nonblock: {
                                nonblock: true
                                },
                                before_close: function(PNotify) {
                                // You can access the notice's options with this. It is read only.
                                //PNotify.options.text;

                                // You can change the notice's options after the timer like this:
                                PNotify.update({
                                    title: PNotify.options.title + " - Enjoy your Stay",
                                    before_close: null
                                });
                                PNotify.queueRemove();
                                return false;
                                }
                            });
                        }
                    },
                    error: function(err) {
                        alert('An unknown error occurred!')
                        console.log(JSON.stringify(err));
                        $('.sendredeem').show();
                    }
                });
            }
            else {
                elmErr = false;
            }
        })
    },

    // Разрешает адресу распоряжаться указанным количеством токенов
    approve: function (address, value) {
        WhiteCoin.approve(address, value, (error, result) => {
            // TODO: Добавить сюда обработку результата
            // console.log(result)
            return result;
        })
    },

    // Дает возможность минтеру создать еще WhiteCoin
    // токены зачисляются на счет минтеру, далее он может
    // передать их через transfer
    mintWhitecoin: function (amount) {
        WhiteCoin.mintWhitecoin(this.convertSendAmount(amount), (error, result) => {
            // TODO: Добавить сюда обработку результата
            console.log(result)
        })
    },

    mintSendWhitecoin: function (to, amount) {
        console.log('Mint Send Whitecoin Begin: '+ to + ' | ' + this.convertSendAmount(amount))
        WhiteCoin.mintingRequest(this.convertSendAmount(amount), 1, (error, result) => {
            // TODO: Добавить сюда обработку результата
            if(error) {
                console.log('Mint Send Whitecoin Error: '+ to + ' | ' + amount + ' | ' + error)
            }
            else {
                console.log('Mint Send Whitecoin Success: '+ to + ' | ' + amount + ' | ' + result)
                WhiteCoin.mintWhitecoin(this.convertSendAmount(amount), (error, result) => {
                    // TODO: Добавить сюда обработку результата
                    console.log('MINT WC: '+result)
                    WhiteCoin.transfer(to, amount);
                })
                
            }
        })
    },

    // Передает право быть менеджером указанному адресу
    transferManager: function(address) {
        WhiteCoin.transferManager(address, (error, result) => {
            // TODO: Добавить сюда обработку результата
            console.log('TRANSFER MANAGER: '+result)
        })
    },

    burn: function (amount) {
        WhiteCoin.burn(this.convertSendAmount(amount), (error, result) => {
            // TODO: Добавить сюда обработку результата
            console.log(result)
        })
    },
    
    burnFrom: function (address, amount) {
        WhiteCoin.burnFrom(address, this.convertSendAmount(amount), (error, result) => {
            // TODO: Добавить сюда обработку результата
            console.log(result)
        })
    },
    
    // Проверяет, является ли адрес менеджером
    isManager: function (address) {
        WhiteCoin.manager(address, (error, result) => {
            // TODO: Добавить сюда обработку результата
            console.log('IS MANAGER: '+result)
        })
    },

    // Возвращает является ли пользователь эмитентом
    isManagerSend: function (val1, val2, val3, val4, val5) {
        App.mintWhitecoinAllow(val1, val2, val3, val4, val5, 1);
        // WhiteCoin.isManager(web3.eth.defaultAccount, (error, result) => {
        //     // TODO: Добавить сюда обработку результата
        //     console.log('MANAGER SEND ALLOW: '+result);
            
        //     if(result) {
        //         App.mintWhitecoinAllow(val1, val2, val3, val4, val5, 1);
        //     }
        //     else {
        //         new PNotify({
        //             title: "White Standard + Metamask",
        //             type: "error",
        //             text: "Be sure you had logged in with Metamask.",
        //             nonblock: {
        //                 nonblock: true
        //             },
        //             before_close: function(PNotify) {
        //                 // You can access the notice's options with this. It is read only.
        //                 //PNotify.options.text;
            
        //                 // You can change the notice's options after the timer like this:
        //                 PNotify.update({
        //                     title: PNotify.options.title + " - Enjoy your Stay",
        //                     before_close: null
        //                 });
        //                 PNotify.queueRemove();
        //                 return false;
        //             }
        //         });
        //     }
        //     // return result;
        // })
    },

    // Возвращает является ли пользователь эмитентом
    isManagerDeny: function (val1, val2, val3, val4, val5) {
        WhiteCoin.isManager(web3.eth.defaultAccount, (error, result) => {
            // TODO: Добавить сюда обработку результата
            console.log('MANAGER SEND DENY: '+result);
            
            if(result) {
                if(confirm("Deny this transaction "+val1)) {
                    App.mintWhitecoinDeny(val5, 2);
                }
            }
            else {
                new PNotify({
                    title: "White Standard + Metamask",
                    type: "error",
                    text: "Be sure you had logged in with Metamask.",
                    nonblock: {
                        nonblock: true
                    },
                    before_close: function(PNotify) {
                        // You can access the notice's options with this. It is read only.
                        //PNotify.options.text;
            
                        // You can change the notice's options after the timer like this:
                        PNotify.update({
                            title: PNotify.options.title + " - Enjoy your Stay",
                            before_close: null
                        });
                        PNotify.queueRemove();
                        return false;
                    }
                });
            }
            // return result;
        })
    },
    
    // Добавляет эмитента
    addManagerSend: function (address, val1, val2, val3, val4) {
        WhiteCoin.transferManager(address, (error, result) => {
            // TODO: Добавить сюда обработку результата
            console.log('IS MANAGER ALLOW: '+result);
            // return result;
            if(result) {
                if(confirm("Allow this transaction "+val1)) {
                    ajaxSend2(val1, val2, val3, val4);
                }
            }
        })
    },

    managerSendWhitecoin: function (to, amount) {
        console.log('MANAGER Send Whitecoin Begin: '+ to + ' | ' + this.convertSendAmount(amount))
        WhiteCoin.mintingRequest(this.convertSendAmount(amount), 1, (error, result) => {
            // TODO: Добавить сюда обработку результата
            if(error) {
                console.log('Mint Send Whitecoin Error: '+ to + ' | ' + amount + ' | ' + error)
            }
            else {
                console.log('Mint Send Whitecoin Success: '+ to + ' | ' + amount + ' | ' + result)
                WhiteCoin.mintWhitecoin(this.convertSendAmount(amount), (error, result) => {
                    // TODO: Добавить сюда обработку результата
                    console.log('MINT WC: '+result)
                    WhiteCoin.transfer(to, amount);
                })
                
            }
        })
    },
    
    // Дает возможность минтеру создать еще WhiteCoin
    // токены зачисляются на счет минтеру, далее он может
    // передать их через transfer
    // mintRequest - номер запроса
    // decision - 1 - если запрос принят, 2 - если запрос отклоненен
    mintWhitecoinAllow: function (val1, val2, val3, val4, mintRequest, decision) {
        WhiteCoin.mintWhitecoin(mintRequest, decision, (error, result) => {
            // TODO: Добавить сюда обработку результата
            console.log('MINT WHITECOIN ALLOW '+result);
            if(result) {
                var datastr = 'act=adminproof2&adr='+val1+'&amnt='+val2;
                $.ajax({
                    type: 'post',
                    url: '/coms/mktransaction.php',
                    data: datastr,
                    success: function(suc) {
                        console.log(JSON.stringify(suc));
                        var suc = JSON.parse(suc);
                        if(suc.success == 1) {
                            $('#transTable').DataTable().ajax.reload();
                        }
                        else if(suc.success == 0) {
                            new PNotify({
                                title: "Error",
                                type: "error",
                                text: "Not enought money!",
                                nonblock: {
                                    nonblock: true
                                },
                                before_close: function(PNotify) {
                                    // You can access the notice's options with this. It is read only.
                                    //PNotify.options.text;
                    
                                    // You can change the notice's options after the timer like this:
                                    PNotify.update({
                                    title: PNotify.options.title + " - Enjoy your Stay",
                                    before_close: null
                                    });
                                    PNotify.queueRemove();
                                    return false;
                                }
                            });
                        }
                        else {
                            new PNotify({
                                title: "Error",
                                type: "error",
                                text: "Transaction could not be recorded!",
                                nonblock: {
                                    nonblock: true
                                },
                                before_close: function(PNotify) {
                                    // You can access the notice's options with this. It is read only.
                                    //PNotify.options.text;
                    
                                    // You can change the notice's options after the timer like this:
                                    PNotify.update({
                                    title: PNotify.options.title + " - Enjoy your Stay",
                                    before_close: null
                                    });
                                    PNotify.queueRemove();
                                    return false;
                                }
                            });
                        }
                    },
                    error: function(err) {
                        alert('Some error occured!')
                    }
                })
            }
        })
    },

    mintWhitecoinDeny: function (val1, val2, val3, val4, mintRequest, decision) {
        WhiteCoin.mintWhitecoin(mintRequest, decision, (error, result) => {
            // TODO: Добавить сюда обработку результата
            console.log('MINT WHITECOIN DENY '+result);
            if(result) {
                var datastr = 'act=adminproof2&adr='+val1+'&amnt='+val2;
                $.ajax({
                    type: 'post',
                    url: '/coms/mktransaction.php',
                    data: datastr,
                    success: function(suc) {
                        console.log(JSON.stringify(suc));
                        var suc = JSON.parse(suc);
                        if(suc.success == 1) {
                            $('#transTable').DataTable().ajax.reload();
                        }
                        else if(suc.success == 0) {
                            new PNotify({
                                title: "Error",
                                type: "error",
                                text: "Not enought money!",
                                nonblock: {
                                    nonblock: true
                                },
                                before_close: function(PNotify) {
                                    // You can access the notice's options with this. It is read only.
                                    //PNotify.options.text;
                    
                                    // You can change the notice's options after the timer like this:
                                    PNotify.update({
                                    title: PNotify.options.title + " - Enjoy your Stay",
                                    before_close: null
                                    });
                                    PNotify.queueRemove();
                                    return false;
                                }
                            });
                        }
                        else {
                            new PNotify({
                                title: "Error",
                                type: "error",
                                text: "Transaction could not be recorded!",
                                nonblock: {
                                    nonblock: true
                                },
                                before_close: function(PNotify) {
                                    // You can access the notice's options with this. It is read only.
                                    //PNotify.options.text;
                    
                                    // You can change the notice's options after the timer like this:
                                    PNotify.update({
                                    title: PNotify.options.title + " - Enjoy your Stay",
                                    before_close: null
                                    });
                                    PNotify.queueRemove();
                                    return false;
                                }
                            });
                        }
                    },
                    error: function(err) {
                        alert('Some error occured!')
                    }
                })
            }
        })
    },
    
    // Дает возможность передавать WhiteCoin
    // Может быть вызвано только менеджером
    startWhitecoinTrading: function () {
        WhiteCoin.startWhitecoinTrading((error, result) => {
            // TODO: Добавить сюда обработку результата
            console.log(result)
        })
    },
    
    // Останавливает возможность передавать WhiteCoin
    // Может быть вызвана только менеджером
    stopWhiteCoinTrading: function () {
        WhiteCoin.stopWhiteCoinTrading((error, result) => {
            // TODO: Добавить сюда обработку результата
            console.log(result)
        })
    },
    
    // Замораживает аккаунт. После этого невозможно передавать WhiteCoin
    freezeAccount: function (address) {
        WhiteCoin.freezeAccount(address, (error, result) => {
            // TODO: Добавить сюда обработку результата
            console.log(result)
        })
    },
    
    unfreezeAccount: function (address) {
        WhiteCoin.freezeAccount(address, (error, result) => {
            // TODO: Добавить сюда обработку результата
            console.log(result)
        })
    },
    
    // Создает новый запрос на минтинг WhiteCoin
    // amount - количество токенов для создания
    // ref - строковый тип
    mintingRequest: function (val1, amount, ref) {
        WhiteCoin.mintingRequest(this.convertSendAmount(amount), ref, (error, result) => {
            // TODO: Добавить сюда обработку результата

            new PNotify({
                title: "Minting request sent",
                type: "success",
                text: "Please wait for transaction complete! Do not refresh or leave this view!",
                nonblock: {
                    nonblock: true
                },
                before_close: function(PNotify) {
                    PNotify.update({
                        title: PNotify.options.title + " - Enjoy your Stay",
                        before_close: null
                    });
                    PNotify.queueRemove();
                    return false;
                }
            });

            WhiteCoin.NewMintingRequest().watch((err, response) => {
                console.log(response.args.amount); // Сумма для эмиссии
                console.log(response.args.id); // Номер запроса, который мы подставляем в mintWhitecoin()
                // TODO: Добавить сюда обработку результата
                console.log('MINT REQUEST '+response.args.id+' | '+response.args.amount)
                if(response.args.id) {

                    console.log('MINT REQUEST '+response.args.id)
                    if(response.args.id) {
                        var datastr = 'act=minterproof&adr='+val1+'&amnt='+response.args.amount+'&fromadr='+response.args.id;
                        $.ajax({
                            type: 'post',
                            url: '/coms/mktransaction.php',
                            data: datastr,
                            success: function(suc) {
                                // console.log(JSON.stringify(suc));
                                $('#transTable').DataTable().ajax.reload();
                            },
                            error: function(err) {
                                alert('Some error occured!')
                            }
                        })
                    }

                }
            })

        })
    }

}

window.addEventListener('load', function() {
    if (typeof web3 !== 'undefined') {
        // console.log("MetaMask detected")
        web3 = new Web3(web3.currentProvider);
    }
    else {
        // TODO: Заставить пользователя скачать или настроить MetaMask
        // console.warn("You should use MetaMask or Mist")
        // window.alert("You should download MetaMask");
        new PNotify({
            title: "WhiteCoin + Metamask",
            type: "error",
            text: "Please log in to Metamask extension!",
            nonblock: {
                nonblock: true
            },
            before_close: function(PNotify) {
                PNotify.update({
                    title: PNotify.options.title + " - Enjoy your Stay",
                    before_close: null
                });
                PNotify.queueRemove();
                return false;
            }
        });
    }
    web3.eth.defaultAccount = web3.eth.accounts[0];
    App.init();
});

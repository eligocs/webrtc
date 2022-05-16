jQuery(function ($) {
	var LEAVEURL = "/student/my-classes";
	var zoom_browser_integration = {
		init: function () {
			var browseinfo = ZoomMtg.checkSystemRequirements();
			var page_html = '<ul><li><strong>Browser Info:</strong> ' + browseinfo.browserInfo + '</li>';
			page_html += '<li><strong>Browser Name:</strong> ' + browseinfo.browserName + '</li>';
			page_html += '<li><strong>Browser Version:</strong> ' + browseinfo.browserVersion + '</li></ul>';
			// page_html += '<li><strong>Available:</strong> ' + browseinfo.features + '</li></ul>';
			// console.log(page_html);

			ZoomMtg.preLoadWasm();
			ZoomMtg.prepareJssdk();

			this.eventHandlers();
		},

		eventHandlers: function () {

			$('#join_meeting_student').on('click', this.loadMeeting.bind(this));
		},

		loadMeeting: function (e) {
			e.preventDefault();
			var meeting_id = document.getElementById('meeting_number').value;
			var iacs_id = document.getElementById('classId').value;
			var LEAVEURL = "/student/subject-detail" + "/" + iacs_id;
			var API_KEY = false;
			var SIGNATURE = false;
			var REDIRECTION = LEAVEURL;
			var PASSWD = document.getElementById('meeting_pwd').value;


			if (meeting_id) {
				$.ajax({
					type: "POST",
					url: WEBURL + '/student/meetingAuth',
					data: { meeting_id: meeting_id, _token: $('meta[name="csrf-token"]').attr('content'), },
					beforeSend: function () {
						console.log(WEBURL + '/student/meetingAuth')
						$('.loader_zoom').show();
					},
					success: function (response) {
						// console.log(response);
						$('.loader_zoom').hide();
						if (response.status == false) {
							alert(response.msg);
							return;
						}



						if (response.status == true) {
							meeting_id = response.meet_id;
							API_KEY = response.key;
							secret = response.secret;
							//SIGNATURE = response.sig;


							var meetConfig = {
								apiKey: API_KEY,
								meetingNumber: parseInt(meeting_id, 10),
								userName: document.getElementById('display_name').value,
								passWord: PASSWD,
								leaveUrl: REDIRECTION,
								role: 0
							};

							var signature = ZoomMtg.generateSignature({
								meetingNumber: meetConfig.meetingNumber,
								apiKey: meetConfig.apiKey,
								apiSecret: secret,
								role: meetConfig.role,
								success: function (res) {
									console.log(res.result);
								}
							});
							if (API_KEY) {
								var display_name = $('#display_name');
								if (!display_name.val()) {
									alert("Name is required to enter the meeting !");
									return false;
								}




								ZoomMtg.init({
									leaveUrl: REDIRECTION, 
									showMeetingHeader: false,
									isSupportAV: true,
									disableInvite: true, 
									meetingInfo: [ 
										'topic',
										'host',
									  ],
									success: function () {
										ZoomMtg.join(
											{
												meetingNumber: meetConfig.meetingNumber,
												userName: meetConfig.userName,
												signature: signature,
												apiKey: meetConfig.apiKey,
												userEmail: 'one@gmail.com',
												passWord: meetConfig.passWord,
												success: function (res) {
													$('#zoom_meeting_section').hide();
													console.log('join meeting success');
												},
												error: function (res) {
													console.log(res.errorMessage)
													alert(res.errorMessage);
													console.log(res);
												}
											}
										);
									},
									error: function (res) {
										console.log(res);
									}
								});
							} else {
								alert("NOT AUTHORIZED");
								return;
							}
						}
					},
					error: function (err, xr) {
						console.log(err)
						console.log(xr)
						$('.loader_zoom').hide();
						alert("Something went wrong. Reload page and try again")
						return;
					}
				});
			} else {
				alert("Incorrect Meeting ID");
				return;
			}
		}
	}
	zoom_browser_integration.init();
})

<?php

// insitute------------------------------
// Home
Breadcrumbs::for('home', function ($trail) {
  $trail->push('Home', route('institute.home'));
});

Breadcrumbs::for('detail', function ($trail, $iacs_id, $subject_id) {
  $trail->parent('home');
  $trail->push('Detail', route('institute.detail', [$iacs_id, $subject_id]));
});

Breadcrumbs::for('liveclass', function ($trail, $iacs_id, $subject_id) {
    $trail->parent('detail', $iacs_id, $subject_id);
    $trail->push('Liveclass', route('institute.listMeeting', [$iacs_id, $subject_id]));
});

Breadcrumbs::for('lectures', function ($trail, $i_assigned_class_subject_id) {
  $iacs = \App\Models\InstituteAssignedClassSubject::findOrFail($i_assigned_class_subject_id);
  $trail->parent('detail', $iacs->id, $iacs->subject_id);
  $trail->push('Lectures', route('institute.lectures.index', ['params']));
});
Breadcrumbs::for('extra_classes', function ($trail, $i_assigned_class_subject_id) {
  $iacs = \App\Models\InstituteAssignedClassSubject::findOrFail($i_assigned_class_subject_id);
  $trail->parent('detail', $iacs->id, $iacs->subject_id);
  $trail->push('Extra_classes', route('institute.extra_classes.index', ['params']));
});
Breadcrumbs::for('assignments', function ($trail, $iacsId) {
  $iacs = \App\Models\InstituteAssignedClassSubject::findOrFail($iacsId);
  $trail->parent('detail', $iacs->id, $iacs->subject_id);
  $trail->push('assignments', route('institute.assignments.index', [$iacsId]));
});

Breadcrumbs::for('tests', function ($trail, $iacsId) {
  $iacs = \App\Models\InstituteAssignedClassSubject::findOrFail($iacsId);
  $trail->parent('detail', $iacs->id, $iacs->subject_id);
  $trail->push('tests', route('institute.topics.index', [$iacsId]));
});

Breadcrumbs::for('questions', function ($trail, $iacsId, $text) {
  $iacs = \App\Models\InstituteAssignedClassSubject::findOrFail($iacsId);

  if (isset($_SERVER['HTTP_REFERER']) && explode('/', $_SERVER['HTTP_REFERER'])[count(explode('/', $_SERVER['HTTP_REFERER'])) - 1] == 'topics') {
    $trail->parent('tests', $iacsId);
  } else if (isset($_SERVER['HTTP_REFERER']) && explode('/', $_SERVER['HTTP_REFERER'])[count(explode('/', $_SERVER['HTTP_REFERER']))
    - 1] == 'assignments') {
    $trail->parent('assignments', $iacsId);
  } else {
    $trail->parent('detail', $iacsId, $iacs->subject_id);
  }
  $trail->push('questions', route('institute.questions.show', ['params1', 'params2']));
});

Breadcrumbs::for('reports', function ($trail, $iacsId, $id) {
  $iacs = \App\Models\InstituteAssignedClassSubject::findOrFail($iacsId);

  if (isset($_SERVER['HTTP_REFERER']) && explode('/', $_SERVER['HTTP_REFERER'])[count(explode('/', $_SERVER['HTTP_REFERER'])) - 1] == 'topics') {
    $trail->parent('tests', $iacsId);
  } else if (isset($_SERVER['HTTP_REFERER']) && explode('/', $_SERVER['HTTP_REFERER'])[count(explode('/', $_SERVER['HTTP_REFERER']))
    - 1] == 'assignments') {
    $trail->parent('assignments', $iacsId);
  } else {
    $trail->parent('detail', $iacsId, $iacs->subject_id);
  }
  $trail->push('reports', route('institute.all_reports.show', ['params1', 'params2']));
});

Breadcrumbs::for('doubts', function ($trail, $iacs_id) {
  $iacs = \App\Models\InstituteAssignedClassSubject::findOrFail($iacs_id);
  $trail->parent('detail', $iacs->id, $iacs->subject_id);
  $trail->push('doubts', route('institute.doubts.index', [$iacs_id]));
});

Breadcrumbs::for('doubt-details', function ($trail, $iacs_id, $id) {
  $trail->parent('doubts', $iacs_id);
  $trail->push($id, route('institute.doubts.show', [$iacs_id, $id]));
});


Breadcrumbs::for('enrollments', function ($trail) {
    $trail->parent('home');
    $trail->push('enrollments', route('institute.enrollments'));
});

// insitute------------------------------

// admin------------------------------
Breadcrumbs::for('Home', function ($trail) {
  $trail->push('Home', route('admin.home'));
});
Breadcrumbs::for('institute-applications', function ($trail) {
  $trail->parent('Home');
  $trail->push('Institute Applications', route('admin.institute-applications.index'));
});
Breadcrumbs::for('resolved-applications', function ($trail) {
  $trail->parent('institute-applications');
  $trail->push('Resolved Applications', route('admin.institute-applications.resolved'));
});
Breadcrumbs::for('view-resolved-applications', function ($trail, $id) {
  $trail->parent('resolved-applications');
  $trail->push('View', route('admin.institute-applications.view', $id));
});

Breadcrumbs::for('manage-institutes', function ($trail) {
  $trail->parent('Home');
  $trail->push('Manage Institutes', route('admin.manage-institutes.index'));
});
Breadcrumbs::for('edit-institute', function ($trail, $id) {
  $trail->parent('manage-institutes');
  $trail->push('Edit', route('admin.manage-institutes.edit', $id));
});

Breadcrumbs::for('view-institute', function ($trail, $id) {
  $trail->parent('manage-institutes');
  $trail->push('View Institute', route('admin.manage-institutes.view-institute', $id));
});
Breadcrumbs::for('view-institute-detail', function ($trail, $id) {
  $trail->parent('view-institute', $id);
  $trail->push('View Institute Detail', route('admin.manage-institutes.view-institute-detail', $id));
});
Breadcrumbs::for('add-new-class', function ($trail, $id) {
  $trail->parent('view-institute', $id);
  $trail->push('Add New Class', route('admin.manage-institutes.add-new-class', $id));
});
Breadcrumbs::for('teachers', function ($trail, $institute_id) {
  $trail->parent('view-institute', $institute_id);
  $trail->push('Teachers', route('admin.teachers.index', $institute_id));
});

Breadcrumbs::for('edit-teacher', function ($trail, $institute_id, $teacher) {
  $trail->parent('teachers', $institute_id);
  $trail->push('Edit', route('admin.teachers.create', [$institute_id, $teacher]));
});

Breadcrumbs::for('create-teacher', function ($trail, $institute_id) {
  $trail->parent('teachers', $institute_id);
  $trail->push('Edit', route('admin.teachers.create', $institute_id));
});

Breadcrumbs::for('institute-detail', function ($trail, $institute_assigned_class_id, $subject_id) {
  $iacs = \App\Models\InstituteAssignedClassSubject::findOrFail($institute_assigned_class_id);
  $iac = \App\Models\InstituteAssignedClass::findOrFail($iacs->institute_assigned_class_id);
  $trail->parent('view-institute', $iac->institute_id);
  $trail->push('Detail', route('admin.institute-subject.detail', [$institute_assigned_class_id, $subject_id]));
});
// admin ------------------------------------------------

// student ----------------------------------------------
Breadcrumbs::for('student_home', function ($trail) {
  $trail->push('Home', route('student.home'));
});
Breadcrumbs::for('subject_detail', function ($trail, $iacs_id) {
  $trail->parent('student_home');
  $trail->push('Detail', route('student.subject_detail', $iacs_id));
});
Breadcrumbs::for('student_extra_classes', function ($trail, $iacs_id) {
  $trail->parent('subject_detail', $iacs_id);
  $trail->push('Extra Classes', route('student.extra-classes', $iacs_id));
});
Breadcrumbs::for('student_doubts', function ($trail, $iacs_id) {
  $trail->parent('subject_detail', $iacs_id);
  $trail->push('Doubts', route('student.doubts', $iacs_id));
});
Breadcrumbs::for('student_assignments', function ($trail, $iacs_id) {
  $trail->parent('subject_detail', $iacs_id);
  $trail->push('Assignments', route('student.assignments', $iacs_id));
});
Breadcrumbs::for('student_tests', function ($trail, $iacs_id) {
  $trail->parent('subject_detail', $iacs_id);
  $trail->push('Tests', route('student.tests', $iacs_id));
});
Breadcrumbs::for('student_start_quiz', function ($trail, $iacs_id, $id) {
  if (!in_array('assignments', request()->segments())) {
    $trail->parent('student_tests', $iacs_id);
    $trail->push('Start', route('student.tests.start_test', [$iacs_id, $id]));
  } else {
    $trail->parent('student_assignments', $iacs_id);
    $trail->push('Start', route('student.assignments.start_assignment', [$iacs_id, $id]));
  }
});


Breadcrumbs::for('student_report', function ($trail, $iacs_id, $id) {
    $trail->parent('student_tests', $iacs_id);
    $trail->push('Reports', route('student.tests.start_test', [$iacs_id, $id]));
});
Breadcrumbs::for('student_finish_quiz', function ($trail, $iacs_id, $id) {
  $trail->parent('subject_detail', $iacs_id);
  $trail->push('Finish', route('student.finish_test', [$iacs_id, $id]));
});
Breadcrumbs::for('search_classes', function ($trail) {
  $trail->parent('student_home');
  $trail->push('Category', route('student.search_classes'));
});
Breadcrumbs::for('enrollable_class', function ($trail, $category_id) {
  $trail->parent('search_classes');
  if ($category_id)
    $trail->push('All Classes', route('student.get_inner_category', ['category_id' => $category_id]));
  else
    $trail->push('All Classes', route('student.inner_category'));
});
Breadcrumbs::for('enrollable_class_detail', function ($trail, $iacs_id) {
  $iacs = \App\Models\InstituteAssignedClassSubject::findOrFail($iacs_id);
  $iac = \App\Models\InstituteAssignedClass::findOrFail($iacs->institute_assigned_class_id);
  $trail->parent('enrollable_class', $iac->category_id);
  $trail->push('Details', route('student.detail', $iacs_id));
});
Breadcrumbs::for('student_revised_lectures', function ($trail, $iacs_id) {
  $trail->parent('subject_detail', $iacs_id);
  $trail->push('Revised Lecture', route('student.revised_lectures', $iacs_id));
});

// student ----------------------------------------------

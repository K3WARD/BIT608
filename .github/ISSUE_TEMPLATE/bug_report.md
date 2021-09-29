---
name: Bug report
about: Create a report to help us improve
title: ''
labels: ''
assignees: ''

---

**Does your log mention database corruption?**
If your Syncthing log reports panics because of database corruption it is
most likely a fault with your system's storage or memory. Affected log
entries will contain lines starting with panic: leveldb. You will need to
delete the index database to clear this, by running syncthing -reset-database.


**Include the following information**


**Describe the bug**
A clear and concise description of what the bug is.

**Version of Ongaonga B&B Booking App**

**To Reproduce**
Steps to reproduce the behavior:
1. Go to '...'
2. Click on '....'
3. Scroll down to '....'
4. See error

**Expected behavior**
A clear and concise description of what you expected to happen.

**Screenshots**
If applicable, add screenshots to help explain your problem.

**Desktop (please complete the following information):**
 - OS: [e.g. iOS]
 - Browser [e.g. chrome, safari]
 - Version [e.g. 22]

**Smartphone (please complete the following information):**
 - Device: [e.g. iPhone6]
 - OS: [e.g. iOS8.1]
 - Browser [e.g. stock browser, safari]
 - Version [e.g. 22]

**Additional context**
Add any other context about the problem here.

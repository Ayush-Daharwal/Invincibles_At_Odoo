**TransitOps**

**Smart Transport Operations Platform**

*Role-Based Task Breakdown — One Login, Four Roles*

# 1. Platform Overview

TransitOps is a role-based access control (RBAC) system for managing a transport fleet: vehicles, drivers, trip dispatch, maintenance, fuel/expenses, and analytics. A single login routes each user into a scoped experience determined by their assigned role — so a Dispatcher never sees financial data, and a Financial Analyst never dispatches a trip.

There are four roles in the system:

- Fleet Manager — owns vehicles and their maintenance lifecycle
- Dispatcher — owns trip creation and the live operations board
- Safety Officer — owns driver records, licensing, and compliance
- Financial Analyst — owns fuel/expense tracking and reporting

The sections below explain each role one by one: what they can see, what they are responsible for doing, the step-by-step workflow they follow, and the business rules the system enforces on their behalf.

# 2. Role-Based Access Matrix

Access is scoped by role immediately after login. This table summarizes what each role can view versus fully manage across the platform's modules.

| Role | Fleet | Drivers | Trips | Fuel / Exp. | Analytics |
|---|---|---|---|---|---|
| Fleet Manager | ✓ Full | ✓ Full | – | – | ✓ Full |
| Dispatcher | View only | – | ✓ Full | – | – |
| Safety Officer | – | ✓ Full | View only | – | – |
| Financial Analyst | View only | – | – | ✓ Full | ✓ Full |

# 3. Roles, One by One

## 3.1 Fleet Manager

*Owns everything about the physical vehicle: onboarding, records, and its maintenance lifecycle.*

**Screen Access**

- Vehicle Registry — full read/write access
- Maintenance — full read/write access
- Drivers — full read/write access (per RBAC matrix)
- Analytics — full access to fleet-level reporting
- Dashboard, Trips, Fuel & Expenses — no direct access

**Core Tasks**

1. Register new vehicles into the Vehicle Registry with registration number, name/model, type, capacity, odometer reading, and acquisition cost.
2. Maintain each vehicle's status across its lifecycle: Available, On Trip, In Shop, or Retired.
3. Log service records when a vehicle needs maintenance — capturing vehicle, service type (e.g. Oil Change, Engine Repair, Tyre Replace), cost, and resulting status.
4. Move a vehicle to 'In Shop' when it requires servicing, which automatically removes it from the dispatcher's live dispatch pool.
5. Close a service record once work is finished, returning the vehicle to Available without marking it Retired.
6. Ensure every vehicle's registration number stays unique across the fleet.
7. Review fleet-level KPIs (active vehicles, available vehicles, vehicles in maintenance, fleet utilization) to plan capacity.

**Typical Workflow**

- Add Vehicle → fill registration/model/type/capacity/odometer/cost → vehicle appears in registry as Available.
- Vehicle needs service → Log Service Record → select vehicle, service type, cost → vehicle flips to In Shop → automatically hidden from Trip Dispatcher.
- Service finishes → close the service log → vehicle returns to Available — without ever being marked Retired.

**Business Rules Enforced**

- Registration number must be unique across the fleet.
- Retired or In Shop vehicles are automatically hidden from the Trip Dispatcher's vehicle picker.
- Closing a service record returns a vehicle to Available; it does not retire it.

## 3.2 Dispatcher

*Owns day-to-day operations: turning a request into an assigned, tracked trip.*

**Screen Access**

- Dashboard — full access (operational KPIs, recent trips, vehicle status)
- Trip Dispatcher — full read/write access to create and manage trips
- Vehicle Registry — view-only, to check availability and capacity
- Drivers, Maintenance, Fuel & Expenses, Analytics — no direct access

**Core Tasks**

1. Monitor the Dashboard for active trips, pending trips, drivers on duty, and overall fleet utilization.
2. Create new trips by selecting an available vehicle, an available driver, source, destination, cargo weight, and planned distance.
3. Track every trip through its lifecycle stages: Draft → Dispatched → Completed, or Cancelled.
4. Use the Live Board to see all trips in progress with their status and ETA at a glance.
5. Cancel a trip when a vehicle unexpectedly goes to the shop or a plan changes.
6. Ensure cargo weight never exceeds a vehicle's rated capacity before dispatching.

**Typical Workflow**

- Create Trip → pick vehicle (available only) → pick driver (available only) → enter source/destination → enter cargo weight & planned distance.
- System checks cargo weight against vehicle capacity — if exceeded, the Dispatch button is disabled with an error (e.g. 'Capacity exceeded by 200 kg — dispatch blocked').
- Trip is dispatched → status becomes Dispatched → visible on the Live Board with ETA.
- On completion: odometer is updated → a fuel log entry is created → expenses are recorded → vehicle and driver both flip back to Available automatically.

**Business Rules Enforced**

- Retired or In Shop vehicles are excluded from the vehicle picker.
- Expired-license or Suspended drivers are blocked from trip assignment.
- Cargo weight exceeding vehicle capacity blocks dispatch until corrected.
- Completing a trip cascades automatically: odometer → fuel log → expenses → vehicle & driver set back to Available.

## 3.3 Safety Officer

*Owns the human side of the fleet: driver records, licensing, and safety compliance.*

**Screen Access**

- Drivers & Safety Profiles — full read/write access
- Trips — view-only, for compliance context on assignments
- Fleet, Fuel & Expenses, Analytics — no direct access

**Core Tasks**

1. Add new drivers with license number, license category (LMV/HMV), license expiry date, and contact details.
2. Track each driver's safety/compliance score based on trip completion history.
3. Monitor license expiry dates and flag or suspend drivers with expired licenses.
4. Toggle driver status between Available, On Trip, Off Duty, and Suspended.
5. Suspend a driver when license validity or safety compliance falls below standard, which blocks them from new trip assignments.

**Typical Workflow**

- Add Driver → enter name, license no., category, expiry date, contact → driver defaults to Available.
- License nears/passes expiry → Safety Officer reviews and updates status → Suspended if expired.
- Suspended or expired-license drivers are automatically excluded from the Dispatcher's driver picker.

**Business Rules Enforced**

- A driver with an expired license or Suspended status is blocked from trip assignment.
- Trip completion rate feeds directly into the driver's safety score.

## 3.4 Financial Analyst

*Owns the money side of the fleet: fuel, expenses, cost tracking, and ROI reporting.*

**Screen Access**

- Fuel & Expense Management — full read/write access
- Reports & Analytics — full access
- Trips — no direct access; Fleet — no direct access

**Core Tasks**

1. Log fuel entries per vehicle: date, liters filled, and fuel cost.
2. Add other trip-linked expenses: toll charges and miscellaneous costs, alongside maintenance costs pulled in automatically.
3. Monitor fleet-wide financial KPIs: fuel efficiency (km/l), fleet utilization, total operational cost, and vehicle ROI.
4. Review the Top Costliest Vehicles report to spot vehicles driving disproportionate expense.
5. Track monthly revenue trends and export reports to CSV for finance/ops reviews.
6. Verify the auto-calculated Total Operational Cost and per-vehicle ROI figures for accuracy before reporting upward.

**Typical Workflow**

- A trip completes → fuel log and linked expenses are auto-created → Financial Analyst reviews and reconciles toll/other charges.
- Log Fuel → select vehicle → enter date, liters, fuel cost → entry feeds fuel-efficiency KPI.
- Add Expense → select trip/vehicle → enter toll and other costs → maintenance cost auto-links → total is computed automatically.
- Open Analytics → review fuel efficiency, utilization, operational cost, and ROI → export CSV as needed.

**Business Rules Enforced**

- Total Operational Cost (auto) = Fuel + Maintenance.
- Vehicle ROI = (Revenue − (Maintenance + Fuel)) ÷ Acquisition Cost.

# 4. Shared / Administrative Screens

## 4.1 Authentication (RBAC Login)

Every role signs in through the same screen — email + password, with a 'Remember me' option and a 'Forgot password?' link. After five failed attempts the account is locked. On success, the system reads the user's assigned role and routes them straight into their scoped experience; no role selection step is shown to the user.

## 4.2 Settings & RBAC

An administrative screen (General + Role-Based Access tabs) where system-wide preferences — currency (INR), distance unit (Kilometers), depot name — are configured, and where the access matrix in Section 2 is defined and maintained. This is where a system administrator would assign or adjust which modules each of the four roles can view versus fully manage.

# 5. Cross-Role Business Rules Summary

These rules span more than one role and keep the four scoped experiences consistent with one another:

- Registration number must be unique per vehicle (Fleet Manager creates it, Dispatcher relies on it).
- Retired or In Shop vehicles are hidden from the Dispatcher's picker (Fleet Manager sets status, Dispatcher consumes it).
- Expired-license or Suspended drivers are blocked from trip assignment (Safety Officer sets status, Dispatcher consumes it).
- Cargo weight exceeding vehicle capacity blocks dispatch (Fleet Manager sets capacity, Dispatcher validates against it).
- Completing a trip cascades automatically into odometer, fuel log, and expenses (Dispatcher completes the trip, Financial Analyst inherits the records).
- Total Operational Cost and Vehicle ROI are computed automatically from Fuel + Maintenance data (Fleet Manager and Financial Analyst both feed this figure).

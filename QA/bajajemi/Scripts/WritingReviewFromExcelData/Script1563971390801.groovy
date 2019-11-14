import static com.kms.katalon.core.checkpoint.CheckpointFactory.findCheckpoint
import static com.kms.katalon.core.testcase.TestCaseFactory.findTestCase
import static com.kms.katalon.core.testdata.TestDataFactory.findTestData
import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject
import com.kms.katalon.core.checkpoint.Checkpoint as Checkpoint
import com.kms.katalon.core.cucumber.keyword.CucumberBuiltinKeywords as CucumberKW
import com.kms.katalon.core.mobile.keyword.MobileBuiltInKeywords as Mobile
import com.kms.katalon.core.model.FailureHandling as FailureHandling
import plp.Resources as Resources
import com.kms.katalon.core.testcase.TestCase as TestCase
import com.kms.katalon.core.testdata.TestData as TestData
import com.kms.katalon.core.testobject.TestObject as TestObject
import com.kms.katalon.core.webservice.keyword.WSBuiltInKeywords as WS
import com.kms.katalon.core.webui.keyword.WebUiBuiltInKeywords as WebUI
import internal.GlobalVariable as GlobalVariable


//@Author: Amit Baghel..
Resources.movingToSmartphonesPage()

WebUI.click(findTestObject('Object Repository/PLPpage/IndividualSmartPhoneLink'))

//WebUI.scrollToElement(findTestObject('Object Repository/WriteReview/WriteReviewButton'), 5)

WebUI.click(findTestObject('Object Repository/WriteReview/WriteReviewButton'))

WebUI.click(findTestObject('Object Repository/WriteReview/RatingObject'))

WebUI.setText(findTestObject('Object Repository/WriteReview/Title'), Title)

WebUI.setText(findTestObject('Object Repository/WriteReview/Description'), Description)

WebUI.click(findTestObject('Object Repository/WriteReview/SubmitButton'))

WebUI.callTestCase(findTestCase('AdminPanel/ApprovingtheReviews'), [:])

